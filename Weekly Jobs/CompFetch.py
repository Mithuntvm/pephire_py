# -*- coding: utf-8 -*-
"""
Created on Mon Dec 30 18:14:00 2019

@author: mithun
"""
import pyodbc
import pandas as pd
import sqlite3 as lite
from Explorer import profile_data

cnxn = pyodbc.connect("DSN=Pephire")    
cursor = cnxn.cursor()
print('Loaded lib')
import pyodbc 

Candidates = pd.read_sql("SELECT * FROM pephire.candidates;", cnxn)
Comp = []
CompDf = pd.DataFrame()
for i, rows in Candidates.iterrows():
    query = f"select * FROM pephire.candidate_companies where candidate_id = '{rows['id']}'"
    CompanyId =  pd.read_sql(query, cnxn)
    CompanyIdList = CompanyId['company_id']
    companylist = []
    for i, item in enumerate(CompanyIdList):
        query = f"select * FROM pephire.companies where id = '{item}'"
        c = pd.read_sql(query, cnxn)
        companylist.append(c['name'][0])
    if len(companylist) == 0:
        companylist.append('')
    print(companylist[0]," : ", rows['name'])
    CompDf = pd.DataFrame()
    CompDf = CompDf.append(profile_data(rows['name'], companylist[0]))
    cursor.execute(f"UPDATE pephire.candidates SET location = '{CompDf['Location'][0]}' WHERE id = '{rows['id']}'")
    cnxn.commit()
    