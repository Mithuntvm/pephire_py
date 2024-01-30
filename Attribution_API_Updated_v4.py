"""
1. Calling getDetails made to an API call
2. Extraction of photo moved from getDetails function to here
"""


from config import extractionDemoURL,ImagePath,RawImagePath
import pymysql
import re
import datetime,json,warnings,requests, sys, os,pandas as pd
print('Attribution server started on '+ str(datetime.datetime.now().time()))
StartTime = datetime.datetime.now().time()
from pathlib import Path
warnings.filterwarnings("ignore")
from flask import Flask, request
from JD_Librariesv7 import getDocxText,getPDFTextasTxt,save_as_docx,getImage
from AttributionResponseWrite_v6 import responsewrite,CheckStatus,UpdateCandidatedetails,responsewriteFailed
src_pdftotxt = r"C:\Pephire\pdftotext.exe"
# json_file='C:\\Pephire\\AttributionReq.txt'
# data = json.load(open(json_file))
# json_table = pd.DataFrame(data)

def is_string_empty_or_none(s):
    return s is None or (isinstance(s, str) and s.strip() == '')
def get_missingfields(row):  
    CompulsoryFields = ['Email','DOB','Passport','Visa','Experience','Sex','Marital_Status','Education','LinkedIn']
    returnlist = []
    for col in CompulsoryFields:
        if row[col] == None or row[col] == 'Nil' or row[col] == '' or row[col] == "None":
            returnlist.append(col)
    return '!'+'|'.join(returnlist)+'!'

app = Flask(__name__)
app.config["DEBUG"] = True
#'/execute=<page>'
@app.route('/parameters', methods=['POST'])
def AttributionAPI_Call():
    start = datetime.datetime.now()
    try:
        Error = pd.DataFrame()    
        jsonf = request.data
        data = json.loads(jsonf.decode("utf-8"))
        json_table = pd.DataFrame(data)  
        #print(str(data).replace('\'','"'))
        # f = open("AttributionTest.txt", "a")
        # f.write(str(data).replace('\'','"'))
        # f.write("\n---------------------------\n")
        # f.close()
        
        f = open("AttributionReq.txt", "w")
        f.write(str(data).replace('\'','"'))
        f.close()
        for d in data:
            FullPath = d['download_link'] 
            CurrentFile = d['download_link'] 
            FileName = d['resume_title']
            ResumeID = d['resume_id']
            UploadSource = d['source']
            OrganizationID = d['organization_id']
            if (FullPath.lower().endswith(".docx")) or (FullPath.lower().endswith(".doc")) or (FullPath.lower().endswith(".pdf")) :
                try:
                    print("Reading "+FileName)
                    extension = Path(CurrentFile).suffix.lower()
                    if extension == '.docx':
                        sDocText = getDocxText(CurrentFile)
                    elif extension == '.doc':
                        save_as_docx(CurrentFile)
                        CurrentFile = CurrentFile.replace(".doc",".docx")
                        sDocText = getDocxText(CurrentFile)
                    elif extension=='.pdf':
                        sDocText = getPDFTextasTxt(CurrentFile)
                    #sDocText_Original = sDocText
                    print('Processing ' + FileName + ' on ' + str(datetime.datetime.now()))
                    #Send call to get details endpoint
                    url = extractionDemoURL
                    sD = str(sDocText).replace("\\n","\n")                    
                    myobj = {"FileName": FileName, "CurrentFile":CurrentFile,"ResumeID":ResumeID,"OrganizationID":OrganizationID,"sDocText":sD}                    
                    # myobj['sDocText'] =  myobj['sDocText'].replace('\n','').replace('\t','').replace('\uf0d8','').replace('\uf0b7','').replace('\xa0','').replace('         ','')
                    # myobj['sDocText'] = re.sub(r'[^\w\s\xa0]', '', myobj['sDocText'])
                    f = open("ExtractionReq.txt", "w")
                    json.dump(myobj,f)
                    f.close()                   
                    x = requests.post(url, json = myobj).text
                    Temp = pd.read_json(x)                    
                    #Get photo for the profile
                    txtPhotoPath = getImage(CurrentFile,r"E:\Pephire_resumes\storage\candidate_photos")
                    txtPhotoPath = txtPhotoPath.replace(ImagePath,'')
                    txtPhotoPath = txtPhotoPath.replace('\\','/')                   
                    Temp['Photo'] = str(txtPhotoPath)

                    IDMapper = json_table[['organization_id','user_id','resume_id','download_link']]
                    Final = pd.merge(Temp,IDMapper,left_on='FileName',right_on='download_link',how='left')
                    Final = Final.drop(['download_link'], axis=1)
                    Final = Final.fillna('Nil') 
                    Final['missingfields'] = Final.apply(get_missingfields, axis = 1)
                    Final['data_completed'] = 0
                    
                    if Final['Email'][0] == "Not Available":
                        Final['Email'][0] = ""
                    if len(Final['missingfields'][0]) == 0:
                        Final['data_completed'] = 1
                    f = open("AttributionRes.txt", "w")
                    Str_Final = Final.to_json(orient = 'records')
                    f.write(Str_Final)
                    f.close()
                    ContactNumber = Final['Contact'][0]
                    if type(ContactNumber) != str:
                        ContactNumber = str(ContactNumber)
                        
                    org_id = Final['organization_id'][0]
                    print('organization id')
                    print(org_id)
                    contact_string = is_string_empty_or_none(ContactNumber)
                    if contact_string == False:
                        cleaned_PhoneNum = ''.join(filter(str.isdigit, ContactNumber))
                        if len(cleaned_PhoneNum) <= 10:
                            cleaned_PhoneNum = '91' + cleaned_PhoneNum
                        ExistingEntry = CheckStatus(cleaned_PhoneNum,org_id)
                        print(ExistingEntry)
                        print('Response')
                        print(Final)
                        if ExistingEntry == 'NewResume':
                            candidate_identifier = responsewrite(Final,ResumeID,UploadSource)
                        elif ExistingEntry == 'ActiveID':
                            cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')
                            cursor = cnx.cursor()
                            sql = ""
                            sql = "select id from pephire.candidates where phone = '"+ContactNumber+"' and organization_id = '"+str(org_id)+"' "
                            cursor.execute(sql)
                            existing_id= cursor.fetchall()
                            columnexisting_id = [desc[0] for desc in cursor.description]
                            df_existing_id = pd.DataFrame(existing_id, columns=columnexisting_id)
                            existing_id = df_existing_id['id'][0]
                            candidate_identifier = existing_id
                            cursor.close()
                            cnx.close()
                        else:
                            active_candidate_id = ExistingEntry
                            UpdateCandidatedetails(active_candidate_id,Final,ResumeID)
                            candidate_identifier = ExistingEntry
                            print(candidate_identifier)
                        if candidate_identifier != '':
                            data_dict = {
                                'candidate_id': str(candidate_identifier),
                                'status': 'success'
                            }
                            
                            # Convert the dictionary to a JSON string
                            json_result = json.dumps(data_dict)
    
                            return json_result
                        else:
                            responsewriteFailed(Final,ResumeID,UploadSource,FileName)
                            data_dict_failed = {
                            'candidate_id':'' ,
                            'status': 'failed'
                            }
                        json_result_failed = json.dumps(data_dict_failed)
                        return json_result_failed
                            
                    else:
                        responsewriteFailed(Final,ResumeID,UploadSource,FileName)
                        data_dict_failed = {
                            'candidate_id':'' ,
                            'status': 'failed'
                            }
                        json_result_failed = json.dumps(data_dict_failed)
                        return json_result_failed
                except Exception as e:
                    print(e)
                    exc_type, exc_obj, exc_tb = sys.exc_info()
                    fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
                    print(exc_type, fname, exc_tb.tb_lineno)
                    Error = Error.append(pd.DataFrame([FileName]))
                    print(FileName, ' Failed')
                    return json.dumps([{'resume_id':ResumeID,'organization_id':OrganizationID,'FileName':FileName, 'Data':'Error'}])
    except:
        return json.dumps([{'resume_id':ResumeID,'organization_id':OrganizationID,'Data':'Error'}])

print(extractionDemoURL)
print('Ready to Serve')
from gevent.pywsgi import WSGIServer
http_server = WSGIServer(('127.0.0.1', 5001), app)
http_server.serve_forever()