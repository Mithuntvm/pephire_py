# -*- coding: utf-8 -*-
"""
Created on Thu Feb  6 15:22:22 2020

@author: mithun
"""

#pephire_string = "host=127.0.0.1,user=root,passwd=password,database=pephire"
#pephire_static_string = "host=127.0.0.1,user=root,passwd=password,database=pephire_static"
#connectParams_pephire = dict(entry.split('=') for entry in pephire_string.split(','))
#connectParams_pephire_static = dict(entry.split('=') for entry in pephire_static_string.split(','))

# =============================================================================
# pephire_db = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire'}
# pephire_db_stat = {'host':'127.0.0.1','user':'root','passwd':'password','database':'pephire_static'}
# 
# engine_string = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire'
# engine_string_stat = 'mysql+mysqlconnector://root:password@127.0.0.1:3306/pephire_static'
# 
# =============================================================================
#user – pephire@pepmysql

#Nopassword4you
pephire_db = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire'}
pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}

engine_string = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com:3306/pephire'
engine_string_stat = 'mysql+mysqlconnector://pephire@pepmysql:Nopassword4you@pepmysql.mysql.database.azure.com:3306/pephire_static'

#SkillNorm and MainCluster are switched in JDLibrariesv1.py based on the variable Domain.
#In Fitment_API_v6.py and RecommendingProfiles.py SkillNorm and Maincluster are imported from JDLibrariesv1.py
#Domain = 1 implies IT 
#Domain = 0 implies Retail
Domain = 1


env = 'demo'
logFlag = 0
ResumeDownloadCount = 3
if env == 'demo':
    user_val='pephire@pepmysql'
    password_val='Nopassword4you'
    host_val='pepmysql.mysql.database.azure.com'
    database_val='pephire_auto'
    
    
elif env == 'Prod':
    user_val='pephire@pepmysql'
    password_val='Nopassword4you'
    host_val='pepmysql.mysql.database.azure.com'
    database_val='pephire_auto'
    
else:
    user_val='pephire@pepmysql'
    password_val='Nopassword4you'
    host_val='pepmysql.mysql.database.azure.com'
    database_val='pephire_auto'
   