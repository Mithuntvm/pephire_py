"""
1. Calling getDetails made to an API call
2. Extraction of photo moved from getDetails function to here
"""


from config import extractionDemoURL 
import datetime,json,warnings,requests, sys, os,pandas as pd
print('Attribution server started on '+ str(datetime.datetime.now().time()))
StartTime = datetime.datetime.now().time()
from pathlib import Path
warnings.filterwarnings("ignore")
from flask import Flask, request
from JD_Librariesv7 import getDocxText,getPDFTextasTxt,save_as_docx,getImage
import pymysql
src_pdftotxt = r"C:\Pephire\pdftotext.exe"
# json_file='C:\\Pephire\\AttributionReq.txt'
# data = json.load(open(json_file))
# json_table = pd.DataFrame(data)
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
        # f = open("AttributionReqHist.txt", "a")
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
                    f = open("ExtractionReq.txt", "w")
                    json.dump(myobj,f)
                    f.close()                   
                    x = requests.post(url, json = myobj).text
                    Temp = pd.read_json(x)                    
                    #Get photo for the profile
                    txtPhotoPath = getImage(CurrentFile,r"C:\Myweb\piphire\public\extracted_images")
                    txtPhotoPath = txtPhotoPath.replace('C:\Myweb\piphire\public\extracted_images','')
                    txtPhotoPath = txtPhotoPath.replace('\\','/')                   
                    Temp['Photo'] = str(txtPhotoPath)

                    IDMapper = json_table[['organization_id','user_id','resume_id','download_link']]
                    Final = pd.merge(Temp,IDMapper,left_on='FileName',right_on='download_link',how='left')
                    Final = Final.drop(['download_link'], axis=1)
                    Final = Final.fillna('Nil') 
                    Final['missingfields'] = Final.apply(get_missingfields, axis = 1)
                    Final['data_completed'] = 0
                    cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')

                    cursor = cnx.cursor()

                    #Check if candidate details are already present in the candidate table
                     
                    sql = "select Email from pephire.monsterresumes"
                    cursor.execute(sql)
                    df_email = cursor.fetchall()
                    columns = [desc[0] for desc in cursor.description]
                    
                    # Create a DataFrame from the fetched rows and column names
                    df_candidateEmail = pd.DataFrame(df_email, columns=columns)
                    print('Updating the details with the details extracted from monster')
                    candidateEmail_list = list(df_candidateEmail['Email'])
                    CandidateEmailId = Final['Email'][0]
                    if CandidateEmailId in candidateEmail_list:

                        #OverWrite the details with the ones in the Monster Resume Table 
                        sql = """select * from pephire.monsterresumes where Email = '""" +CandidateEmailId+"""' """
                        cursor.execute(sql)
                        df_emailDetails = cursor.fetchall()
                        columnsDetails = [desc[0] for desc in cursor.description]
                        cursor.close()
                        cnx.close()
                        # Create a DataFrame from the fetched rows and column names
                        df_candidateEmailDetails = pd.DataFrame(df_emailDetails, columns=columnsDetails)
                        Name = df_candidateEmailDetails['Name'][0]
                        Experience = str(df_candidateEmailDetails['Experience'][0])
                        Education = df_candidateEmailDetails['Education'][0]
                        Role = df_candidateEmailDetails['Role'][0]
                        Location = df_candidateEmailDetails['Location'][0]
                        CTC = str(df_candidateEmailDetails['CTC'][0])
                        Final = pd.DataFrame({'a': ['a'], 'b': ['b'], 'c': ['c'], 'd': ['d']})
                        Final.loc[Final['Email'] == CandidateEmailId, ['Name', 'Education', 'Experience','Role']] = [Name,Education,Experience, Role]
                        Final['location'] = Location
                        Final['ctc'] = CTC
                       
                        print("Write details to candidate table")

                    if Final['Email'][0] == "Not Available":
                        Final['Email'][0] = ""
                    if len(Final['missingfields'][0]) == 0:
                        Final['data_completed'] = 1
                    jsonObject = Final.to_dict(orient='records')  
                    Op = json.dumps(jsonObject) 
                    end = datetime.datetime.now()
                    timediff = end - start
                    
                   
                    print(FileName + ' Success. Duration = ' + str(timediff.seconds) + 'sec')
                    print('----------------------------------------------------------------------------')
                    f = open("AttributionRes.txt", "w")
                    f.write(str(json.dumps(jsonObject) ))
                    f.close()
                    # cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')

                    # cursor = cnx.cursor()

                    # #Check if candidate details are already present in the candidate table
                     
                    # sql = "select Email from pephire.monsterresumes"
                    # cursor.execute(sql)
                    # df_email = cursor.fetchall()
                    # columns = [desc[0] for desc in cursor.description]

                    # # Create a DataFrame from the fetched rows and column names
                    # df_candidateEmail = pd.DataFrame(df_email, columns=columns)
                    # print('Updating the details with the details extracted from monster')
                    # candidateEmail_list = list(df_candidateEmail['Email'])
                    # CandidateEmailId = Final['Email'][0]
                    # if CandidateEmailId in candidateEmail_list:
                    #     #OverWrite the details with the ones in the Monster Resume Table 
                    #     sql = """select * from pephire.monsterresumes where Email = '""" +CandidateEmailId+"""' """
                    #     cursor.execute(sql)
                    #     df_emailDetails = cursor.fetchall()
                    #     columnsDetails = [desc[0] for desc in cursor.description]

                    #     # Create a DataFrame from the fetched rows and column names
                    #     df_candidateEmailDetails = pd.DataFrame(df_emailDetails, columns=columnsDetails)
                    #     Name = df_candidateEmailDetails['Name'][0]
                    #     Experience = df_candidateEmailDetails['Experience'][0]
                    #     Education = df_candidateEmailDetails['Education'][0]
                    #     Role = df_candidateEmailDetails['Role'][0]
                    #     Location = df_candidateEmailDetails['Location'][0]
                    #     CTC = df_candidateEmailDetails['CTC'][0]
                    #     sQry = """update pephire.candidates set name=' """+Name+""" ',experience=' """+str(Experience)+""" ',education=' """+Education+"""',role=' """+Role+"""',ctc=' """+str(CTC)+"""',location=' """+Location+"""' where email='""" + CandidateEmailId +"""';"""
                    #     cursor.execute(sQry)
                        # cnx.commit()
                        
                        
                    return Op
                    
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