from Lib_v1 import db_read, db_write
import pandas as pd
import mysql.connector

pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}
mydb = mysql.connector.connect(**pephire_db_stat)
mycursor = mydb.cursor()
df = pd.read_csv("C:/Pephire/Jobsbylocation_localDB.csv", error_bad_lines=False)
df=df.fillna('')
sql2 = 'INSERT INTO pephire_static.jobsbylocation VALUES('
for i,r in df.iterrows():       
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
    sUG = str(r['UG :'])+   "')"
    sQry  = sql2 + sDoctorate + sEmployment + nExperience + sFunctional + sIndustry  + sJob + sLocation + sPG + sRole + sRC + sSkills + sUG

    if i%100 == 0:
        print('writting row no ' + str(i))    
    try:
        mycursor.execute(sQry)
    except:
        pass
mydb.commit()
mydb.close()