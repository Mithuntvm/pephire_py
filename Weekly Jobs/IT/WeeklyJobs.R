tryCatch({
  source('C:/Pephire/Weekly Jobs/IT/PephireStaticTables_V5.R')
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
  outMail[["subject"]] = paste0("-------------R code Execution Failed----------------")
  outMail[["body"]] = paste0("Saving the data to the static tables have failed")
  
  ## send it                     
  outMail$Send()
  

})