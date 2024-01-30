from selenium import webdriver
import pandas as pd
import time, datetime
from selenium.webdriver.common.keys import Keys
from lib import SendmailAlert

def ITJobs(sSkill,driver):
    f = open("ITjob_New.log", "a")
    starttime = datetime.datetime.now()
    f.write("\nWeb crawling started for " + sSkill+" at " + str(starttime))
    f.close()
    #Open linked in and login
    driver = webdriver.Chrome(r'chromedriver.exe')
    driver.maximize_window()
    driver.get("https://www.Naukri.com")
    time.sleep(15)
    #First click on search control to enable it and then enter the search location
    try:
        SearchBox = driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[1]/div/div/div/div[1]/div/input')
    except:
        time.sleep(10)
        SearchBox = driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[1]/div/div/div/div[1]/div/input')

    SearchBox.click()
    time.sleep(3)
    SearchBox.send_keys(sSkill+u'\ue007')
    time.sleep(5)
    #Initialize the list for holding the urls and counter to navigate 4 pages
    JobURLs = []    
    cnt=1
    #While pages traversed is less than 4
    while cnt<=4:      
        #Get the html control that holds all the job listings and find all elements that hold the job entries
        # Xpath="//div[@class='content']/section[2]/div[2]"    
        Xpath="/html/body/div[1]/div/main/div[1]/div[2]/div[2]/div"
        JobContainer = driver.find_element_by_xpath(Xpath)
        # JobPosts = JobContainer.find_elements_by_tag_name('article')   
        JobPosts = JobContainer.find_elements_by_class_name('srp-jobtuple-wrapper')    
        for JobPost in JobPosts:
            links = JobPost.find_elements_by_tag_name('a')
            #Add only the first hyperlink to url list
            for i in range(len(links)):
                #print(links[i].get_attribute('href'))
                if i==0:
                    JobURLs.append(links[i].get_attribute('href'))
        for i in range(10):
            try:
                driver.find_element_by_link_text('Next').click()
                break
            except:
                driver.find_element_by_tag_name('body').send_keys(Keys.PAGE_DOWN)
        cnt = cnt + 1
        time.sleep(5)
        print('URls retrieved ' + str(len(JobURLs)))
    
    f = open("ITjob_New.log", "a")
    f.write("\nUrls obtained for " + sSkill) 
    f.close()
    #Loop through each job using the job urls
    Jobs = pd.DataFrame() 
    i=0
    for JobURL in JobURLs:
        print(JobURL)
        try:
            driver.get(JobURL)
            time.sleep(3)
            #i=i+1
            #print(sSkill+ '-' + str(i))
            Details = {}
            #Details['Location'] = 'Retail'
            #Get Experience
            try:
                Xpath = "/html/body/div[1]/div/main/div[1]/div[1]/section[2]/div[1]/div"
                txtExp = driver.find_element_by_class_name('styles_jhc__exp__k_giM')
                Details['Experience'] = txtExp.text
            except:
                pass
            try:
                txtExpSalary = driver.find_element_by_class_name('styles_jhc__salary__jdfEC').text
                Details['Salary'] = txtExpSalary
                print('Salary')
                print(txtExpSalary)
            except:
                pass
            #Get job description
            JobDetailSection = driver.find_element_by_class_name('styles_job-desc-container__txpYf')
            #Create a dictionary which can hold key value combination. We add keys and values on each data fetch and finally convert to a dataframe
            
            try:
                JobDetails = driver.find_element_by_class_name('styles_job-desc-container__txpYf')
                txtJobDetails = JobDetails.text
                Details['Job Description'] = txtJobDetails
            except Exception as e:
                pass
                #print(e)
                #print('Not able to find JobDetails')
            #Get control that hold other details
            OtherDetailsContainer = JobDetailSection.find_element_by_class_name('styles_other-details__oEN4O')
            OtherDetails = OtherDetailsContainer.text
            lines = OtherDetails.split('\n')

            # Create a dictionary from the lines
            otherDetails_dict = {}
            for line in lines:
                key, value = line.split(': ', 1)  # Split at the first occurrence of ': ' to handle cases where the value contains ': '
                otherDetails_dict[key] = value
            
            # Update the existing dictionary with new keys and values
            Details.update(otherDetails_dict)

                #print(txtLabel + ' ==== '+ txtLabelValue)
            
            #Get control that hold educational details
            EducationDetailsContainer = JobDetailSection.find_element_by_class_name('styles_education__KXFkO')
            EducationDetails = EducationDetailsContainer.text
            Education_lines = EducationDetails.split('\n')

            # Create a dictionary from the lines
            Education_dict = {}
            for item in Education_lines[1:]:     
                key, value = item.split(': ', 1)     
                Education_dict[key] = value
            Education_dict.setdefault('Doctorate', '')
            # Update the existing dictionary with new keys and values
            Details.update(Education_dict)
                #print(txtLabel + ' ==== '+ txtLabelValue)
            
            KeySkillContainer = JobDetailSection.find_element_by_class_name('styles_key-skill__GIPn_')
            Skills = KeySkillContainer.find_elements_by_tag_name('a')
            txtSkill = ""
            for Skill in Skills:
                txtSkill = txtSkill + Skill.text + ', '
            Details['Skills'] = txtSkill  
            #Convert dictionary to data frame
            CurrentJobDetails = pd.DataFrame([Details])
            #CurrentJobDetails['JobID']=sID
            #Add each job detail to main table
            #sIndustry = CurrentJobDetails['Industry Type'][0]
            Jobs = Jobs.append(CurrentJobDetails)
            Jobs.to_excel('NewJobDetails.xlsx')
        except:
            file1 = open("ErrorSkill.txt","a")#append mode 
            #file1.write(JobURL + "\n") 
            file1.write(sSkill + "\n") 
            file1.close()
    driver.quit()
    f.close()
    return Jobs

StartTime = time.localtime()

pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
    

#from sqlalchemy import create_engine
import mysql.connector
def SavetoDB(df_ITJobs):
    print("started saving")
    f = open("ITjob.log", "a")
    f.write("\nJob save to DB started")
    #engine = create_engine(engine_string_static, echo=False)
    #con = engine.raw_connection()
    df_ITJobs['Location']='All'
    df_ITJobs = df_ITJobs.reset_index()
    df_ITJobs = df_ITJobs.rename(columns={'Employment Type:': 'Employment Type', 'Industry Type:': 'Industry Type', 'Role Category:': 'Role Category','Department' :'Functional Area'}) 
    df_ITJobs = df_ITJobs[['Doctorate', 'Employment Type', 'Experience', 'Functional Area','Industry Type', 'Job Description','Location','PG','Role','Role Category', 'Skills', 'UG','Salary']]
    mydb = mysql.connector.connect(**pephire_db_stat)
    mycursor = mydb.cursor()
    ExistingJobs = pd.read_sql("SELECT * FROM pephire_static.jobsbylocation;", mydb)
    df_ITJobs.columns = ExistingJobs.columns
    ExistingJobs = ExistingJobs.append(df_ITJobs)
    ExistingJobs = ExistingJobs.drop_duplicates()
    ExistingJobs1 = ExistingJobs.copy()
    ExistingJobs1 = ExistingJobs1.reset_index(drop = True)
    #ExistingJobs1.columns = ['Doctorate.:','Employment.Type','Experience','Functional.Area','Industry.Type','Job.Description','Location','PG.:','Role','Role.Category','Skills','UG.:']
    ExistingJobs1 = ExistingJobs1[ExistingJobs1['Industry Type'].str.upper().str.startswith('IT')| ExistingJobs1['Industry Type'].str.upper().str.contains('SOFTWARE')]    
    ExistingJobs1 = ExistingJobs1.reset_index(drop = True)
    ExistingJobs1['Job Description'] =  ExistingJobs1['Job Description'].str.replace("'","\\'")
    #Saving to DB
    mycursor.execute('delete FROM pephire_static.jobsbylocation;')
    mydb.commit()
    sql2 = 'INSERT INTO pephire_static.jobsbylocation VALUES('
    for i,r in ExistingJobs1.iterrows():       
        sDoctorate = "'" + str(r['Doctorate :']) +  "','"
        sEmployment = str(r['Employment Type']) +  "','"
        nExperience =str(r['Experience']) +  "','"    
        sFunctional = str(r['Functional Area'])+  "','"
        sIndustry = str(r['Industry Type'])+  "','"
        sJob = str(r['Job Description'])+  "','"
        sLocation = str(r['Location'])+  "','"
        sPG = str(r['PG :'])+  "','"
        sRole = str(r['Role'])+  "','"
        sRC = str(r['Role Category'])+  "','"
        sSkills = str(r['Skills'])+  "','"
        sUG = str(r['UG :'])+   "','"
        Salary = str(r['Salary'])+   "')"
        sQry  = sql2 + sDoctorate + sEmployment + nExperience + sFunctional + sIndustry  + sJob + sLocation + sPG + sRole + sRC + sSkills + sUG + Salary

        if i%100 == 0:
            print('writting row no ' + str(i))    
        try:
            mycursor.execute(sQry)
        except:
            pass
    mydb.commit()
    mydb.close()
    f.write("\nJob save to DB completed")
    f.close()