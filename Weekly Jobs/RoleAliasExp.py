# -*- coding: utf-8 -*-
"""
Created on Sat Jul 18 13:49:09 2020

@author: mithun
"""
import pandas as pd
import mysql.connector
from sqlalchemy import create_engine
from config import pephire_db_stat,engine_string_stat
engine = create_engine(engine_string_stat, echo=False)



df_RoleAlias = pd.read_excel('RoleAlias.xlsx', sheet_name = 'RoleMapsV1')
df_RoleAlias['Domain'] = 'IT'
df_RoleAlias.to_sql(name='rolealias', con=engine, if_exists = 'replace', index=False)






engine.dispose()








# =============================================================================
# 
# mydb_static = mysql.connector.connect(**pephire_db_stat)
# RoleExpMap = pd.read_sql("select Role, Experience from pephire_static.jobsbylocation", mydb_static)
# RoleExpMap['ExpStripped'] = RoleExpMap['Experience'].str.replace(r" years","").str.extract("([0-9A-Za-z]+$)")
# RoleExpMap['Num2'] = pd.to_numeric(RoleExpMap['ExpStripped'])
# 
# RoleExpMap['ExpStripped1'] = RoleExpMap['Experience'].str.extract("([0-9]+)")
# RoleExpMap['Num1'] = pd.to_numeric(RoleExpMap['ExpStripped1'])
# 
# RoleExpMap['Experience'] = (RoleExpMap['Num1']+RoleExpMap['Num2'])/2
# RoleExpMap = RoleExpMap[['Role','Experience']]
# 
# RoleExpMap = RoleExpMap.groupby('Role')['Experience'].min().reset_index()
# RoleExpMap['Role'] = RoleExpMap['Role'].str.lower()
# RoleAlias = pd.read_sql("select * from pephire_static.rolealias", mydb_static)
# 
# RoleExpToRoleAlias =pd.merge(RoleExpMap, RoleAlias, on = "Role", how = "left", indicator = True)
# RoleExpOnly = RoleExpToRoleAlias[RoleExpToRoleAlias['_merge'] == "left_only"]
# 
# RoleAliasToRoleExp =pd.merge(RoleAlias, RoleExpMap, on = "Role", how = "left", indicator = True)
# RoleAliasOnlyNewTable = RoleAliasToRoleExp[RoleAliasToRoleExp['_merge'] == "both"]
# RoleAliasOnlyNewTable = RoleAliasOnlyNewTable[['Role Category', 'Role', 'Alias', 'Domain', 'Experience']]
# RoleAliasOnlyNewTable.columns = ['Role Category', 'Role', 'Alias', 'Domain', 'MinExperience']
# RoleAliasOnly = RoleAliasToRoleExp[RoleAliasToRoleExp['_merge'] == "left_only"]
# RolesOnlyInRoleAlias = RoleAliasOnly['Role'].drop_duplicates().reset_index()
# RolesInRoleAlias = RoleAlias['Role'].drop_duplicates().reset_index()
# RoleAliasOnly.to_excel("RoleAliasOnly.xlsx")
# 
# 
# 
# RoleAliasOnlyNewTable.to_sql(name='rolealias_exp', con=engine, if_exists = 'replace', index=False)
# 
# engine.dispose()
# =============================================================================
