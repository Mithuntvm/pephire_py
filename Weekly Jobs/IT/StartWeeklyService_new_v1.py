from WeeklyJobs_Schedular_new import WeeklyService
from Jobs_IT_new_v1 import  SavetoDB
from lb import SendmailAlert,SendMailAttachItem
# from SMTP import SendSMTPMail
import datetime
import mysql.connector
import pandas as pd
from skillsdelta import getNewSkills
pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
    

#from sqlalchemy import create_engine
import mysql.connector
startTime = datetime.datetime.now().strftime("%I:%M%p on %B %d, %Y")
Subject = 'Weekly Job Started'
Message = 'Weekly Job started ' +startTime
SendmailAlert(Subject,Message)

print('Get existing skills')
oldSkills = getNewSkills()
oldSkills.to_excel('oldSkills.xlsx')
print('start weekly service')
pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
mydb = mysql.connector.connect(**pephire_db_stat)
mycursor = mydb.cursor()
ExistingJobsinTable= pd.read_sql("SELECT * FROM pephire_static.jobsbylocation;", mydb)
output = WeeklyService()
print('Output')
print(output)
output.to_excel('WeeklyJobsResult.xlsx')
#Get new jobs added

df_TotalJobs = output.merge(ExistingJobsinTable.drop_duplicates(), how='left', indicator=True)
newlyAddedJobs = df_TotalJobs[df_TotalJobs['_merge'] == 'left_only'].drop(columns='_merge')
newlyAddedJobs.to_excel('NewJobsAdded.xlsx')

EndTime = datetime.datetime.now().strftime("%I:%M%p on %B %d, %Y")
Subject = 'Weekly Job Result'
Message = 'Weekly Job successfully completed at ' + EndTime
SendMailAttachItem(Subject,Message)
#SavetoDB(output)
mydb = mysql.connector.connect(**pephire_db_stat)
mycursor = mydb.cursor()
ExistingJobs_MainCluster = pd.read_sql("SELECT * FROM pephire_static.maincluster;", mydb)
ExistingJobs_MainCluster.to_excel('MainCluster.xlsx')
ExistingJobs_newskillnorm = pd.read_sql("SELECT * FROM pephire_static.newskillnorm;", mydb)
ExistingJobs_newskillnorm.to_excel('newskillnorm.xlsx')
ExistingJobs_rolealias = pd.read_sql("SELECT * FROM pephire_static.rolealias;", mydb)
ExistingJobs_rolealias.to_excel('rolealias.xlsx')
mydb.close()




