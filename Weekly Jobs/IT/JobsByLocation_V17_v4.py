from selenium import webdriver
import pandas as pd
import time
from selenium.webdriver.common.keys import Keys
import openpyxl
import win32com.client as win32
JobsBySkill = pd.DataFrame()
try:
    Location = pd.read_excel(r'Locations.xlsx')
    for i,row in Location.iterrows():
        try:
            location = row['Location']
            driver = webdriver.Chrome(executable_path=r'chromedriver.exe')
            driver.maximize_window()
            driver.get("https://www.Naukri.com")
            time.sleep(15)    
            try:
                driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[1]/div/div/div/div[1]/div/input').send_keys('a')
                SearchBox = driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[5]/div/div/div/div[1]/div/input')
            except:
                time.sleep(10)
                driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[1]/div/div/div/div[1]/div/input').send_keys('a')
                SearchBox = driver.find_element_by_xpath('//*[@id="root"]/div[7]/div/div/div[5]/div/div/div/div[1]/div/input')
            
            SearchBox.click()
            time.sleep(3)
            #SearchBox.send_keys('Bangalore')
            SearchBox.send_keys(location+u'\ue007')
            #SearchBox.send_keys(location)
            #driver.find_element_by_class_name('btn').click()
            time.sleep(5)
            JobURLs = []    
            cnt=1
            #While pages traversed is less than 4
            print("Getting jobs by location")
            while cnt<=5:      
                #Get the html control that holds all the job listings and find all elements that hold the job entries
                print(cnt)
                # Xpath="//div[@class='content']/section[2]/div[2]" 
               
                Xpath="/html/body/div[1]/div/main/div[1]/div[2]/div[2]/div"
                JobContainer = driver.find_element_by_xpath(Xpath)
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
            #f.write("\nUrls obtained for " + sSkill)   
            #Loop through each job using the job urls
            Jobs = pd.DataFrame() 
            i=0
            df_Skillsnew = pd.DataFrame()
            for JobURL in JobURLs:
                print(JobURL)
                try:
                    time.sleep(3)
                    driver.get(JobURL)
                    time.sleep(3)
                    #sID = GetID(JobURL)
                    i=i+1
                    print('IT '+ '-' + str(i))
                    Details = {}
                    #Details['Location'] = 'Retail'
                    #Get Experience
                    try:
                        txtExp = driver.find_element_by_class_name('exp').text
                        Details['Experience'] = txtExp
                    except:
                        pass
                    
                    #Get job description
                    JobDetailSection = driver.find_element_by_class_name('styles_job-desc-container__txpYf')
                    #Create a dictionary which can hold key value combination. We add keys and values on each data fetch and finally convert to a dataframe
                    
                    try:
                        JobDetails = driver.find_element_by_class_name('styles_JDC__dang-inner-html__h0K4t')
                        txtJobDetails = JobDetails.text.replace(':','')
                        Details['Job Description'] = txtJobDetails
                    except:
                        print('Not able to find JobDetails')
                    #Get control that hold other details
                    OtherDetailsContainer = JobDetailSection.find_element_by_class_name('styles_other-details__oEN4O')
                    OtherDetails = OtherDetailsContainer.find_elements_by_class_name('details')
                    for OtherDetail in OtherDetails:
                        Label = OtherDetail.find_element_by_tag_name('label')
                        txtLabel = Label.text.replace(':','')
                        LabelValue = OtherDetail.find_element_by_tag_name('span')
                        txtLabelValue = LabelValue.text
                        Details[txtLabel] = txtLabelValue
                   
                    #Get control that hold educational details
                    EducationDetailsContainer = JobDetailSection.find_element_by_class_name('styles_education__KXFkO')
                    EducationDetails = EducationDetailsContainer.find_elements_by_class_name('details')
                    for EducationDetail in EducationDetails:
                        Label = EducationDetail.find_element_by_tag_name('label')
                        txtLabel = Label.text.replace(':','')
                        LabelValue = EducationDetail.find_element_by_tag_name('span')
                        txtLabelValue = LabelValue.text
                        Details[txtLabel] = txtLabelValue
                        #print(txtLabel + ' ==== '+ txtLabelValue)
                    KeySkillContainer = JobDetailSection.find_element_by_class_name('styles_key-skill__GIPn_')
                    Skills = KeySkillContainer.find_elements_by_tag_name('a')
                    txtSkill = ""
                    for Skill in Skills:
                        txtSkill = txtSkill + Skill.text + ', '
                    Details['Skills'] = txtSkill 
                    Details['Location'] = location
                    #Convert dictionary to data frame
                    CurrentJobDetails = pd.DataFrame([Details])
                    #CurrentJobDetails['JobID']=sID
                    #Add each job detail to main table
                    #sIndustry = CurrentJobDetails['Industry Type'][0]
                    Jobs = Jobs.append(CurrentJobDetails)
                    Jobs_backup = Jobs
                    Jobs = Jobs.reset_index(drop = True)
                    # Jobs = Jobs[Jobs['Industry Type'].str.upper().str.startswith('IT')|Jobs['Industry Type'].str.upper().str.contains('SOFTWARE')]
                    # Getting new skill set from naukri
                    Skills_new = Jobs['Skills']
                    #Jobs['Skills1'] = Jobs['Skills'].apply(lambda x: x.split(','))
                    a = Jobs['Skills'].str.cat(sep =',').split(',')
                    a = [x.strip() for x in a]
                    b = pd.DataFrame({'Skills':a})
                    b['Key'] = 1
                    #df_Skillsnew=df_Skillsnew.append(b)
                    JobsBySkill = JobsBySkill.append(b)    
                except:
                    file1 = open("ErrorFiles.txt","a")#append mode 
                    print("Failed")
                    file1.write(JobURL + "\n") 
                    file1.close()
            driver.close()
        except:
            driver.close()
    
    
    
    try:        
        JobsBySkill = JobsBySkill.groupby(by='Skills',as_index=False).agg({'Key':sum})
        JobsBySkill = JobsBySkill.sort_values(by = 'Key',axis = 0,ascending=False).reset_index(drop=True)
        JobsBySkill = JobsBySkill[JobsBySkill.index<10]    
        JobsBySkill=JobsBySkill.drop(['Key'],axis=1)
        JobsBySkill = JobsBySkill[['Skills']].dropna()
        JobsBySkill = JobsBySkill[JobsBySkill['Skills']!=""]
        JobsBySkill = JobsBySkill.reset_index(drop = True)
        JobsBySkill.index+=1
        JobsBySkill.index.name ='Row'
        JobsBySkill.columns=['SkillCombination']    
        #Fetching the old skill set from excel
        Skills_lastweek = pd.read_excel(r'SearchQry.xlsx',sheet_name = 'Sheet2')
        # Skills_lastweek = Skills_lastweek['SkillCombination'].values.tolist()
        JobsBySkill['time'] = pd.to_datetime(pd.Timestamp.now())
        JobsBySkill.to_excel('JobsBySkill.xlsx')
        # Skills_thisweek = JobsBySkill['SkillCombination'].values.tolist()
        # Merging the two skill sets
        df_SkillsUpdated = pd.concat([Skills_lastweek,JobsBySkill],ignore_index = True) 
        # Skills_Updated = Skills_thisweek + Skills_lastweek    
        # Skills = list(set(Skills_Updated))
        # df_Skills = pd.DataFrame({'SkillCombination':Skills}).dropna()
        df_Skills = df_SkillsUpdated.sort_values('time').drop_duplicates('SkillCombination', keep='first')
        df_Skills = df_Skills[df_Skills['SkillCombination']!=""]
        df_Skills = df_Skills.reset_index(drop = True)
        df_Skills.index+=1
        df_Skills.set_index('SkillCombination')
        df_Skills.index.name ='Row'
        workbook=openpyxl.load_workbook('SearchQry.xlsx')
        workbook.get_sheet_names()
        std=workbook.get_sheet_by_name('Sheet2')
        #Removing the existing excel sheet
        workbook.remove_sheet(std)
        #Creating the excel sheet with updated skills
        #df_Skillsnew.to_excel('C:/Pephire/SearchQry.xlsx',sheet_name = 'Sheet2')
        df_Skills.to_excel('SearchQry.xlsx',sheet_name = 'Sheet2')
        print('Success')
        outlook = win32.Dispatch('outlook.application')
        mail = outlook.CreateItem(0)
        mail.To = 'sanjna@sentientscripts.com'
        mail.Subject = 'JobsByLocation Service successful'
        mail.Body = 'Successfully created the skill set'
        mail.Send()
    
    except:
        print('Failed')
        driver.quit()
    # outlook = win32.Dispatch('outlook.application')
    # mail = outlook.CreateItem(0)
    # mail.To = 'sanjna@sentientscripts.com'
    # mail.Subject = 'JobsByLocation Service failed'
    # mail.Body = 'Failed to create the skill set'
    # mail.Send()
    
    
except:
    
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = 'JobsByLocation Service failed'
    mail.Body = 'JobsByLocation Service failed'
    mail.Send()
