# -*- coding: utf-8 -*-
"""
Created on Fri Nov 12 18:22:51 2021

@author: mithun
"""
import pandas as pd
import mysql.connector
from sqlalchemy import create_engine
from config import pephire_db_stat,engine_string_stat
engine = create_engine(engine_string_stat, echo=False)
#Get the count of roles in the current DB
mydb_static = mysql.connector.connect(**pephire_db_stat)
cursor = mydb_static.cursor()
df_Roles = pd.read_sql("SELECT count(*) FROM pephire_static.rolealias;", mydb_static)
nRoleCount = int(df_Roles['count(*)'].iloc[0])
#If current role table is empty, load with initial set
if nRoleCount==0:
    engine = create_engine(engine_string_stat, echo=False)
    df_RoleAlias = pd.read_excel('RoleAlias.xlsx', sheet_name = 'RoleMapsV1')
    df_RoleAlias['Domain'] = 'IT'
    df_RoleAlias.to_sql(name='rolealias', con=engine, if_exists = 'replace', index=False)
    engine.dispose()
else:
    df_CurrentRoles = pd.read_sql("SELECT * FROM pephire_static.rolealias;", mydb_static)
    df_JobRoles = pd.read_sql("SELECT distinct Role,Role Category FROM pephire_static.jobsbylocation;", mydb_static)
    df_CurrentRoles = df_CurrentRoles[['Alias','Role Category']]
    df_CurrentRoles.columns = ['Role','Category']
    if df_CurrentRoles.shape[0]>0:
        df_CurrentRoles['Key'] = df_CurrentRoles['Role'].str.lower() + df_CurrentRoles['Category'].str.lower()
    if df_JobRoles.shape[0]>0:
        df_JobRoles['Key'] = df_JobRoles['Role'].str.lower() + df_JobRoles['Category'].str.lower()
    if df_JobRoles.shape[0]>0 and df_CurrentRoles.shape[0]>0:
        df_NewRoles = df_JobRoles[~df_JobRoles['Key'].isin(df_CurrentRoles['Key'].tolist())]
        df_NewRoles = df_NewRoles[['Role','Category']]
        df_NewRoles['Domain'] =  'IT'
        for i,row in df_NewRoles.iterrows():
            sQry = "insert into pephire_static.rolealias values('" + row['Role'] + "','" + row['Role'] + "','" + row['Category'] +"','" + row['Domain'] + "')"
            cursor.execute(sQry)
        mydb_static.commit()
        df_RoleMaster = pd.read_sql('SELECT distinct(role) FROM pephire_static.rolealias;',mydb_static)
        df_RoleCategoryMaster = pd.read_sql('SELECT distinct(`Role Category`) FROM pephire_static.rolealias;',mydb_static)
        cursor.execute('delete FROM pephire_static.roles_master')
        cursor.execute('delete FROM pephire_static.rolecategory_master')
        mydb_static.commit()
        for i,row in df_RoleMaster.iterrows():
            sQry = "insert into pephire_static.roles_master values('" + row['role']+ "','IT')"
            cursor.execute(sQry)
        mydb_static.commit()
        
        for i,row in df_RoleCategoryMaster.iterrows():
            sQry = "insert into pephire_static.rolecategory_master values('" + row['Role Category']+ "','IT')"
            cursor.execute(sQry)
        mydb_static.commit()
    
    
mydb_static.close()
