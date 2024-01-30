jobs = openxlsx::read.xlsx('jobsbyloc.xlsx')
jobs1 = jobs[-1]
library(RMySQL)

db_user <- 'pephire@pepmysql'
db_password <- 'Nopassword4you'
db_name <- 'pephire_static'
db_host <- 'pepmysql.mysql.database.azure.com' # for local access
db_port <- 3306
db_table <- 'jobsbylocation'
mydb <-  dbConnect(MySQL(), user = db_user, password = db_password, dbname = db_name, host = db_host, port = db_port)
dbWriteTable(mydb, value = jobs1, name = "jobsbylocation", overwrite  = TRUE, row.names = FALSE )
dbDisconnect(mydb)
