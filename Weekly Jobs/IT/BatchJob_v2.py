from Jobs_IT_v1 import ITJobs, SavetoDB
import pandas as pd, datetime
import win32com.client as win32
try:
    
    NewSkillCombination = pd.read_excel(r'SearchQry.xlsx', sheet_name = 'Sheet2')
    JobsBySkill = pd.DataFrame()
    for i,row in NewSkillCombination.iterrows():
        print(str(row['Row']) + ' out of ' + str(NewSkillCombination.shape[0]))
        f = open('jobsIT_New.log','a')
        f.writelines(row['SkillCombination']+' ')
        f.close()
        try:
            Temp = ITJobs(row['SkillCombination'])
            JobsBySkill = JobsBySkill.append(Temp)
        except:
            pass
    
    start = datetime.datetime.now()
    SavetoDB(JobsBySkill)
    print("jobsbylocation printing time: ", datetime.datetime.now()-start)
    
    JobsBySkill.to_excel('Jobs_26042023.xlsx')
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = 'Batch Job successful'
    mail.Body = 'Saving the data to skillsbylocation table has been successfully completed'
    mail.Send()
    
except:
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = 'Batch Job failed'
    mail.Body = 'Saving the data to skillsbylocation table has failed'
    mail.Send()



