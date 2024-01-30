from pathlib import Path
import re,os, sys, datetime
import pandas as pd
from docx import Document
from config import pephire_db, pephire_db_stat
from docx.opc.constants import RELATIONSHIP_TYPE as RT

from JD_Librariesv5 import save_as_docx,getDocxText,getPDFTextasTxt,getDOB,getPassport, extDOB, extPassport, extMaritalStatus, getMaritalStatus, getVisaStatus, extVisaStatus , similar, getSex, getImage,getEducationalQualification,ProfileSensing, getAllRoles
import mysql.connector
from personality import mbtDesc
#load the skillwords that are clustered. This is saved in DB based on daily or weekly jobs that pull data from naukri
#mydb = mysql.connector.connect(**pephire_db)
#mycursor = mydb.cursor()
mydb_static = mysql.connector.connect(**pephire_db_stat)
mycursor_static = mydb_static.cursor()
Traits = pd.read_sql("SELECT * FROM pephire_static.traits;", mydb_static)
mydb_static.close()
#def GetDetails(src_pdftotxt,FileName,CurrentFile,Skills,ResumeID):
def GetDetails(src_pdftotxt,FileName,CurrentFile,ResumeID,OrganizationID):
    print("Reading "+FileName)
    #mydb.reconnect()
    extension = Path(CurrentFile).suffix.lower()
    if extension == '.docx':
        sDocText = getDocxText(CurrentFile)
    elif extension == '.doc':
        save_as_docx(CurrentFile)
        CurrentFile = CurrentFile.replace(".doc",".docx")
        sDocText = getDocxText(CurrentFile)
    elif extension=='.pdf':
        sDocText = getPDFTextasTxt(CurrentFile)
    #sDocTextActual = str(sDocText)    
    sDocText_Original = sDocText
    sDocText = sDocText.lower().replace(',',' ').replace('\u2019', '') 
    sDocText = sDocText.replace("","").replace('\t', ' ')
    sDocText = sDocText.replace('\n', '|NEWLINE|')
    sDocText = re.sub('\s+', ' ', sDocText)
    sDocText = sDocText.replace('|NEWLINE|', '\n')
    txtName = txtMail = txtDOB = txtPassport = txtVisa= txtMartialStatus=txtMobNum=txtExp=txtLinkedInMail=txtSex=txtPhotoPath=""
    #if extension=='.pdf':
        #Lines = sDocText.split('  ')
    #else:
    Lines = sDocText.splitlines()
        
    #If the entire text is returned as one line then use another pdf package and split lines 
    Lines = [l for l in Lines if l]
    Lines = pd.DataFrame(Lines, columns=['Lines']) 
    Result = pd.DataFrame()
    for i in range(Lines.shape[0]):
        if((len(Lines['Lines'][i])<2) or (re.findall(r"[0-9\-+_/]+", Lines['Lines'][i]))):
            Lines = Lines.drop(i,axis=0)
        elif(len(Lines['Lines'][i])>2):
            break
    
    #Get first line as name and assign to result set
    Lines = Lines.reset_index()
    bName = False
    FileName = os.path.splitext(FileName)[0]
    if '_' in FileName:
        NameComp = FileName.split('_')[0]
    else:
        NameComp = FileName.split()[0]
    for i in range(Lines.shape[0]):
        if((similar(Lines['Lines'][i],NameComp.lower())>=0.25 and NameComp.lower() in Lines['Lines'][i]) or (similar(Lines['Lines'][i],NameComp.lower())>=0.85)):
            try:
                txtName = Lines['Lines'][i]
                txtName = txtName.replace("name","").strip(" :->\t")
                bName = True
            except:
                pass
            break
    if(bName==False):
        txtName=FileName.lower().replace("resume","").replace("updated","").strip(" ")
    txtName = re.sub("resume|of","",txtName).strip(" \t:")
    txtName = re.sub('[\+\(\_0-9]','',txtName)
    txtName = txtName.title()
    if txtName=='':
        txtName = FileName
        txtName = txtName[:txtName.rfind('.')]
        txtName = re.sub(r'[^a-zA-Z]', ' ', txtName)
        txtName = re.sub(r'\s+', ' ', txtName)
        txtName = re.sub(r'\W+', ' ', txtName)
        txtName = re.sub(r'[', ' ', txtName)
        txtName = re.sub(r']', ' ', txtName)
    data = {'Attribute':'FileName',"Value" : CurrentFile}
    Result = Result.append(pd.DataFrame(data, index=[0]) )
    data = {'Attribute':'Name',"Value" : str(txtName)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )    
    #print('Name retrieved')
    ##Get email using regular expression
    try:
        txtMail = re.findall(r"[a-z0-9\.\-+_]+@[a-z0-9\.\-+_]+\.[a-z]+", sDocText)
        txtMail = txtMail[0].strip(" :")
    except:
        try:
            document = Document(CurrentFile)
            rels = document.part.rels
            for rel in rels:
                if rels[rel].reltype == RT.HYPERLINK:
                    if (rels[rel]._target.find('mailto:') != -1):
                        txtMail = rels[rel]._target
                        txtMail = re.sub('mailto:','',txtMail)
        except:
            txtMail =""
    if len(txtMail)<5:
        txtMail=""
    data = {'Attribute':'Email',"Value" : str(txtMail)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )

    #Get Linked in email using regular expression
    #txtLinkedInMail = re.findall(r"[a-z0-9\.\-+_]+@linkedin.com+", sDocText)
    txtLinkedInMail = re.findall(r"linkedin.com[^\s^\n^\t]+", sDocText)
    try:
        txtLinkedInMail = txtLinkedInMail[0].strip(" :")        
    except:
        txtLinkedInMail = ""
   
    data = {'Attribute':'LinkedIn',"Value" : str(txtLinkedInMail)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )
    #Get phone numbers
    try:        
        PhoneNumbers = re.findall(r'[0+\+\(]?[1-9 ]+[0-9 .\-\(\)]{8,}[0-9]', sDocText)
        PhoneNumbers = pd.DataFrame(PhoneNumbers)
        PhoneNumbers.columns = ['Phone']
        ph = ""
        #Get the matching regex that starts with +
        for i in range(PhoneNumbers.shape[0]):
            t = PhoneNumbers['Phone'][i]
            if(t.startswith('+')):
                ph = PhoneNumbers['Phone'][i]
                break
            elif(t.startswith('00')):
                ph = re.sub("^(00)","+",PhoneNumbers['Phone'][i])
                break
            elif re.search(r'^\d{10}$', t):
                ph = PhoneNumbers['Phone'][i]
                break
            elif len(re.findall(r'\d', t)) == 10:
                ph = PhoneNumbers['Phone'][i]
                ph = re.sub(r'[^\d]','', ph)
                break
        if ph =="":
            txtMobNum = PhoneNumbers['Phone'][i].strip(" :")
        else:
            txtMobNum = ph.strip(" :")
        if ph =="":
            txtMobNum = PhoneNumbers['Phone'][i].strip(" :")
        else:
            txtMobNum = ph.strip(" :")
    except:
        txtMobNum = ""
    if len(re.findall('\d',txtMobNum))<10:
        txtMobNum = ""
    txtMobNum = re.sub('[\(\)]','',txtMobNum)
    data = {'Attribute':'Contact',"Value" : str(txtMobNum)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )
    
    #Get years of experience
    Lines['YearFlag']=  Lines['Lines'].str.contains("year|yrs|yr")
    Years =  Lines[Lines['YearFlag']==True]
    Years = Years[['Lines','YearFlag']].reset_index()
    Years['Text'] = ""
    for i in range(Years.shape[0]):
        temp = Years['Lines'][i]
        temp = temp.replace("yr","year")
        try:
            if re.search('year', temp) and re.search(r'\d+', temp):
                t1 = re.findall(r"\d+|\d+\.\d+",temp)
            #Get the digit that is closest in position to the word indicating year("year|yrs|yr")
            YrPos = re.search("year|yr",temp).start()
            tempPos = [(abs(re.search(j,temp).start() - YrPos),j) for j in t1]
            ExpYear = [x[1] for x in tempPos if x[0] == min(tempPos)[0]][0]
            #maxYear = getMaxYear(t1)
            Years['Text'][i]=ExpYear
        except:
            Years['Text'][i]=0
    #convert the string column to int and remove values greater than 50
    Years['Text'] = Years['Text'].astype(float)
    Years = Years[Years['Text']!=" "]
    Years = Years[Years['Text']<50]     
    
    txtExp = pd.to_numeric(Years.Text, errors='coerce').max()
    data = {'Attribute':'Experience',"Value" : str(txtExp)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )
    dobFlag, passFlag, maritFlag, VisaFlag = False, False, False, False
    
    #Loop through lines to get details
    for i in range(Lines.shape[0]):
        try:
            Line = Lines['Lines'][i]
            if txtDOB=="":
                if not dobFlag:
                    txtDOB, dobFlag = getDOB(Line)
                    if dobFlag and txtDOB=="":
                        txtDOB = extDOB(Lines['Lines'][i+1])
                if txtDOB!="":
                    txtDOB = txtDOB.strip(" :\t")
                    txtDOB = re.sub(r'[^\x00-\x7f]', '',txtDOB)
                    data = {'Attribute':'DOB',"Value" : str(txtDOB)}
                    Result = Result.append(pd.DataFrame(data, index=[0]) )
            if(txtPassport==""):
                txtPassport, passFlag = getPassport(Line)
                if passFlag and txtPassport=="":
                    txtPassport = extPassport(Lines['Lines'][i+1])
                txtPassport = txtPassport.strip(" .:\t")
                txtPassport = re.sub(r'[^\x00-\x7f]',r'',txtPassport)
                if(txtPassport!=""):
                    data = {'Attribute' : 'Passport',"Value" : str(txtPassport)}
                    Result = Result.append(pd.DataFrame(data, index=[0]) )
            if(txtVisa==""):
                txtVisa,VisaFlag = getVisaStatus(Line)
                if VisaFlag and txtVisa=="":
                    txtVisa = extVisaStatus(Lines['Lines'][i+1])
                txtVisa = re.sub(r'[^\x00-\x7f]',r'',txtVisa.strip(" :\t"))
                if(txtVisa!=""):
                    data = {'Attribute':'Visa' ,"Value": str(txtVisa)}
                    Result = Result.append(pd.DataFrame(data, index=[0]) )
            if(txtMartialStatus==""):
                txtMartialStatus,maritFlag  = getMaritalStatus(Line)
                if maritFlag and txtMartialStatus=="":
                    txtMartialStatus = extMaritalStatus(Lines['Lines'][i+1])
                txtMartialStatus = txtMartialStatus.strip(" .:\t")
                txtMartialStatus = re.sub(r'[^\x00-\x7f]',r'',txtMartialStatus)
                if(txtMartialStatus!=""):
                    data = {'Attribute':'Marital_Status',"Value" : str(txtMartialStatus)}
                    Result = Result.append(pd.DataFrame(data, index=[0]) )
        except:
            pass
                
   
    
    #Get photo for the profile
    txtPhotoPath = getImage(CurrentFile,r"C:\www\piphire\public\extracted_images")
    txtPhotoPath = txtPhotoPath.replace('C:\www\piphire\public\extracted_images','')
    txtPhotoPath = txtPhotoPath.replace('\\','/')
    data = {'Attribute':'Photo',"Value" : str(txtPhotoPath)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )    
   
    #Get gender
    try:
        txtSex = getSex(sDocText)
    except:
        txtSex = ""
    data = {'Attribute':'Sex',"Value" : str(txtSex)}
    Result = Result.append(pd.DataFrame(data, index=[0]) )
   

    #get educational detail
    try:
        txtEducation = getEducationalQualification(sDocText_Original)
    except:
        txtEducation = ''    
    #print("Educational Qualification : " + txtEducation)
    data = {'Attribute':'Education',"Value" : txtEducation}
    Result = Result.append(pd.DataFrame(data, index=[0]) ) 
    #print('Name, email, linkedin, phone, Passport, DOB, Visa ,marital status,Photo, Gender, Education extracted')
    #Get roles and role category
    #print('Role Function  ' + str(datetime.datetime.now()))
    df_Top3Roles = getAllRoles(CurrentFile,sDocText)
    
    try:
        if(df_Top3Roles.shape[0]>0):
            RoleTable = df_Top3Roles.nsmallest(1,'Location').reset_index()  
            sRoleCategory = RoleTable['Role'][0]
            sRole = RoleTable['Alias'][0]
        else:
            sRoleCategory,sRole='',''
            print('No roles identified')
    except Exception as e:
        print(e)
        exc_type, exc_obj, exc_tb = sys.exc_info()
        fname = os.path.split(exc_tb.tb_frame.f_code.co_filename)[1]
        print(exc_type, fname, exc_tb.tb_lineno)
        print('Not able to find roles')
        sRoleCategory,sRole ='',''  
    data = {'Attribute':'RoleCategory',"Value" : sRoleCategory}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    data = {'Attribute':'Role',"Value" : sRole}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    #print('Role details extracted')
    #print('Skill Function  ' + str(datetime.datetime.now()))
    #Identify the skill and save to DB. Return value 1 on success
    try:
        SkillsDf = ProfileSensing(CurrentFile,ResumeID,sDocText, txtMobNum, OrganizationID)
        if(SkillsDf.shape[0]>0):
            Skills = SkillsDf['Skills'][0]
            SubSkills = SkillsDf['SubSkills'][0]
        else:
            print('No skill identified')
            Skills, SubSkills = '',''
    except:
        Skills, SubSkills = '',''

    data = {'Attribute':'SkillIdentified',"Value" : Skills}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    data = {'Attribute':'SubSkillIdentified',"Value" : SubSkills}
    Result = Result.append(pd.DataFrame(data, index=[0]))  
    #print('Skill Function  completed' + str(datetime.datetime.now()))
    print(Skills)
   
    #Identify the role and save to DB. Return value 1 on success
    try:
        sRolesTagger = '|'.join(df_Top3Roles['RoleScore'].to_list())
    except:
        sRolesTagger = ''
    #print("RolesTagger : ", sRolesTagger)
    data = {'Attribute':'Roles_Tagged',"Value" : sRolesTagger}
    Result = Result.append(pd.DataFrame(data, index=[0]))    
    
    #print('Role_Tagger extracted')
    #Get Character assessment details
    CharacterCode = mbtDesc(sDocText)
    #print(CharacterCode)
    f = open("Characters.txt", "a")
    f.write( '\n' + txtName + ' - ' + CharacterCode)
    f.close()
    ProfileTrait = Traits[Traits['Code']==CharacterCode]
    
    ProfileTrait['Text'] = ProfileTrait['Text'].str.replace('<Name>',txtName)
    
    if(txtSex =='f'):
        ProfileTrait['Text'] = ProfileTrait['Text'].str.replace('his/her','her').str.replace('him/her','her').str.replace('he/she','she').str.replace('she/he','she')
    else:
        ProfileTrait['Text'] = ProfileTrait['Text'].str.replace('his/her','his').str.replace('him/her','him').str.replace('he/she','he').str.replace('she/he','he')
    
    CharacterAssessment = pd.DataFrame(ProfileTrait[['Trait','Text']])
    CharacterAssessment = CharacterAssessment.T
    CharacterAssessment.columns = CharacterAssessment.loc['Trait',:]
    CharacterAssessment = CharacterAssessment.drop(['Trait'],axis=0)
    
    txtEngage = CharacterAssessment['Engage'][0]
    txtProductivity = CharacterAssessment['Productivity'][0]
    txtCorporateculture = CharacterAssessment['Corporate culture'][0]
    txtStrengths = CharacterAssessment['Strengths'][0]
    
    data = {'Attribute':'Engage',"Value" : txtEngage}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    data = {'Attribute':'Productivity',"Value" : txtProductivity}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    data = {'Attribute':'Corporateculture',"Value" : txtCorporateculture}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    data = {'Attribute':'Strengths',"Value" : txtStrengths}
    Result = Result.append(pd.DataFrame(data, index=[0]))
    #print('Character assessed')
    Reference = pd.DataFrame({'Attribute':['FileName','Name', 'Email', 'Contact', 'DOB', 'Passport', 'Visa',
                                           'Marital_Status','Experience','LinkedIn','Sex','Photo',
                                           'SkillIdentified','SubSkillIdentified','Roles_Tagged',
                                           'Education','RoleCategory','Role','Engage','Productivity','Corporateculture',
                                           'Strengths']}) 
    
    Reference = Reference.reset_index()
    Reference = Reference.merge(Result,'left','Attribute')
    Reference = Reference.drop(['index'],axis=1)
    ResultRow = Reference.T
    ResultRow.columns = ResultRow.iloc[0]
    ResultRow = ResultRow[1:]
    return ResultRow