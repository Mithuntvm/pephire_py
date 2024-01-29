from Lib_v1 import db_read, db_write
import pandas as pd

pephire_db_stat = {'host':'pepmysql.mysql.database.azure.com','user':'pephire@pepmysql','passwd':'Nopassword4you','database':'pephire_static'}

df = pd.read_csv("C:/Pephire/Jobsbylocation_localDB.csv")
df=df.fillna('')