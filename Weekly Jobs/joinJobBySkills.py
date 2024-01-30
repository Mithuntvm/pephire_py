# -*- coding: utf-8 -*-
"""
Created on Wed Jan 22 14:09:38 2020

@author: ADMIN123
"""
import pandas as pd
import mysql.connector
from os import listdir
from os.path import isfile, join
from sqlalchemy import create_engine

#List all the tables to be appended
onlyfiles = [f for f in listdir(r"C:\Pephire\JobsBySkill") if isfile(join(r"C:\Pephire\JobsBySkill", f))]
JobsBySkill = pd.DataFrame()
for i in onlyfiles:
    CurrentFile = pd.read_excel(i)
    JobsBySkill = JobsBySkill.append(CurrentFile)
JobsBySkill = JobsBySkill.drop(['Unnamed: 0'], axis = 1)

#create engine, connection and a cursor
engine = create_engine('mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_static', echo=False)
con = engine.raw_connection()
curs = con.cursor()

#Connect to mysql db and create a cursor
mydb = mysql.connector.connect(host="127.0.0.1",user="root", passwd="password", database="pephire_static")
mycursor = mydb.cursor()
mycursor.execute('delete FROM pephire_static.jobsbylocation;')
mydb.commit()

#Changes '\' to '' and "'" to "\'". In SQL string breaks when "'" is encountered (eg: last year's value). So it should be inserted as "\'" to sql(eg:last year\'s value )
def cleanup(x):
    for i,item in enumerate(x):
        x[i] = str(x[i])
        #Remove "\" in string to avoid combination of "\'"  in original string 
        x[i] = x[i].replace("\\","")
        #Change "'" to "\'"
        x[i] = x[i].replace("'","\\'")
    return(x)

#Apply cleanup function to all string type columns
JobsBySkill = JobsBySkill.apply(lambda x: cleanup(x),axis = 1)
#JobsBySkill = JobsBySkill.drop(['Unnamed: 0'],axis = 1)

#Write tables to db
a = ''
#Clear the table to be replaced
curs.execute('delete from pephire_static.jobsbylocation')
sql2 = 'INSERT INTO pephire_static.jobsbylocation VALUES('
for i,r in JobsBySkill.iterrows():
    #Remove unnamed if not in the table
    Unnamed = "'" + str(r['Unnamed: 0']) +  "',"
    sDate = "'" + str(r['Doctorate :']) +  "',"
    sEmploymentType =  "'" + r['Employment Type'] +  "',"
    sExperience = "'" + r['Experience'] +  "',"
    sFnA = "'" + r['Functional Area'] +  "',"   
    sIT = "'" + r['Industry Type']+  "'," 
    sJD = "'" + r['Job Description']+  "',"
    sLocation = "'" + r['Location']+  "',"
    sPG = "'" + r['PG :']+  "',"
    sRole = "'" + r['Role']+  "',"
    sRC = "'" + r['Role Category']+  "',"
    sSkills = "'" + r['Skills']+  "',"
    sUG = "'" + r['UG :'] +   "')"
    sQry  = sql2 + Unnamed + sDate + sEmploymentType + sExperience + sFnA + sIT + sJD  + sLocation + sPG + sRole +sRC+sSkills+sUG
    print('writting row no ' + str(i))
    a= sQry
    curs.execute(sQry)
con.commit()
engine.dispose()
