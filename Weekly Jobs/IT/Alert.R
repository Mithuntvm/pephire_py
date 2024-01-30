tryCatch({
  source('C:/Pephire/Weekly Jobs/IT/PephireStaticTables_V523332.R')
  # If the code runs successfully, break the loop and exit
  break
}, error = function(e) {
  library(RDCOMClient)
  ## init com api
  OutApp <- COMCreate("Outlook.Application")
  ## create an email 
  outMail = OutApp$CreateItem(0)
  ## configure  email parameter 
  outMail[["To"]] = "sanjna@sentientscripts.com"
  outMail[["subject"]] = paste0("-------------PMAS Execution Failed----------------")
  outMail[["body"]] = paste0("Execution failed")
  
  ## send it                     
  outMail$Send()
  

})