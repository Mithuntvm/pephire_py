library(RMySQL)
library(dplyr)
library(readxl)
library(reshape)
library(reshape2)
library(tidyr)
library(splitstackshape)
library(tm)
library(stringr)
library(data.table)
library(gtools)
library(stringi)
library(stringr)

print(paste0('Job started on',Sys.time()))
setwd('C:/Pephire/Weekly Jobs/IT')
options(stringsAsFactors = FALSE)
# 2. Settings
db_user <- 'pephire@pepmysql'
db_password <- 'Nopassword4you'
db_name <- 'pephire_static'
db_host <- 'pepmysql.mysql.database.azure.com' # for local access
db_port <- 3306
db_table <- 'jobsbylocation'

print('Static tables job started')
SkillMapping_L1<-function(SkillWords)
{
  #Create a duplicate for final merging
  Original = select(SkillWords,value)
  #Drop duplicates
  #Retain Original as it is, as it needs to be merged with SkillMapping towards the end
  Original = as.data.frame(unique(select(Original,value)))
  colnames(Original) = "Skill"
  #Create a lower case column as key
  Original$Word = tolower(Original$Skill)
  #Change all entries to lower case
  SkillWords$value = tolower(SkillWords$value)
  SkillWords = select(SkillWords,value)
  #Get the TotalOccurances of Words
  df_TotalOccurances = SkillWords %>% group_by(value) %>% summarise(TotalOccurance=n())
  colnames(df_TotalOccurances) = c('Skill','TotalOccurance')
  
  #Drop duplicates
  SkillWords = unique(SkillWords)
  #Remove non alphabets with length < 2
  SkillWords = data.frame(SkillWords[(nchar(SkillWords$value) > 2) | (nchar(SkillWords$value) < 2 & !grepl("^[a-zA-Z]+$",SkillWords$value)),])
  colnames(SkillWords) = "Skill"
  #Order the Skills based on occurance in descending order. In the final mapping while loop, we need to look for similarity of the highest
  #occuring words in order with other words and remap.
  SkillWords = merge(SkillWords,df_TotalOccurances,by='Skill',all.x = TRUE)
  
  
  #Reset row index
  rownames(SkillWords) <- NULL
  #Select only the skill column as that is only needed for further processing
  print('Loop1')
  ###Data cleanup using highest occurring references
  #Reduction process. Sort words by occurrance in the descending order and look for words below that begins with teh current word
  #and replace the below words, if it starts with current words followed by space
  SkillWords <-SkillWords[order(-SkillWords$TotalOccurance),]
  {
    {
      MatchingEntries = data.frame()
      t1 = SkillWords
      t1$Word = ""
      t1$WordOccurance=0
      print(nrow(t1))
      for (i in 1:nrow(t1))
      {
        if ((i%%100)==0)
          print(i)
        currentSkill = t1$Skill[i]
        currentSkillCount = t1$TotalOccurance[i]
        for (j in i:nrow(t1))
        {
          if(startsWith(t1$Skill[j],paste0(currentSkill," ")) && t1$Word[j]=="" && str_length(currentSkill)>5)
          {
            t1$Word[j] = currentSkill
            t1$WordOccurance[j] = currentSkillCount
          }
        }
      }
      t1$L1 = if_else(t1$Word=="",t1$Skill,t1$Word)
      t1$TotalOccurance = as.numeric(t1$TotalOccurance)
      t1$WordOccurance = as.numeric(t1$WordOccurance)
      t1$WordOccurance1 = if_else(t1$WordOccurance==0,t1$TotalOccurance,t1$WordOccurance)
    }
  }
  t1
} 
SkillMapping_L2 <- function(MappedtoCount)
{
  lstAlphabets = c('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z')
  df_Words = select(MappedtoCount,MappedTo)
  df_Mapped = data.frame()
  for (alpha in lstAlphabets)
  {
    print(alpha)
    df_Temp = subset(MappedtoCount,startsWith(MappedTo,alpha))
    df_Temp = subset(df_Temp,str_length(df_Temp$MappedTo)>5)
    df_Temp$ID = "1" 
    df = merge(df_Temp,df_Temp,by = "ID",allow.cartesian=TRUE,all = TRUE)
    #First round of cleanup using similarity with words as it is
    df_Temp1 = df
    df_Temp1$Sim = stringdist::stringdist(df_Temp1$MappedTo.x,df_Temp1$MappedTo.y,method = "lv")
    df_Temp1 = subset(df_Temp1,Sim==1)
    df_Temp1=subset(df_Temp1,Count.x>Count.y) 
    
    #Second round of cleanup using similarity with words after removing the special characters in it
    df_Temp2 = df
    df_Temp2$MappedTo.x_Text = str_replace_all(df_Temp2$MappedTo.x, "[^[:alnum:]]", "")
    df_Temp2$MappedTo.y_Text = str_replace_all(df_Temp2$MappedTo.y, "[^[:alnum:]]", "")
    df_Temp2$Sim = stringdist::stringdist(df_Temp2$MappedTo.x_Text,df_Temp2$MappedTo.y_Text,method = "lv")
    df_Temp2 = subset(df_Temp2,Sim<2)
    df_Temp2=subset(df_Temp2,Count.x>Count.y) 
    #Remove words that are covered in second loop from first loop
    t1 = select(df_Temp1,MappedTo.x,MappedTo.y)
    t2 = select(df_Temp2,MappedTo.x,MappedTo.y)
    colnames(t1)=c('MappedTo','Word')
    colnames(t2)=c('MappedTo','Word')
    t1 = subset(t1, !Word %in% as.list(t2$Word))
    df_final = rbind(t1,t2)
    
    #There might be cases one word has two mapping. So get the mappedto that has most occurrance and map the word to that mappedTo
    df_finalCount = merge(df_final,MappedtoCount,by='MappedTo')
    df_finalMaxCount = df_finalCount %>% group_by(Word)%>%summarise(Count=max(Count))
    df_FinalMapping = merge(df_finalCount,df_finalMaxCount,by=c('Word','Count'))
    #Append mapping of current alphabet to entire set
    df_Mapped = rbind(df_Mapped,df_FinalMapping)
  }
  df_Mapped
}
CreateCooccuranceMatrix = function(SkillWords)
{
  Table = SkillWords
  colnames(Table) = c("ID","Skill")
  SkillWords_SkillWords = merge(Table,Table,by = "ID",allow.cartesian=TRUE)
  SkillWords_SkillWords = SkillWords_SkillWords[SkillWords_SkillWords$Skill.x!=SkillWords_SkillWords$Skill.y,]
  CoOccurance = SkillWords_SkillWords %>% group_by(Skill.x,Skill.y) %>% summarize(Count = n())
  CoOccurance
}


Synonyms = read_excel('SkillWords_Config.xlsx', sheet = "Synonyms")
CommonWords = read_excel('SkillWords_Config.xlsx', sheet = "CommonWords")
IgnoreListMainCluster = read_excel("IgnoreListMainCluster_new.xlsx")
print('Loading jobs')
mydb <-  dbConnect(MySQL(), user = db_user, password = db_password, dbname = db_name, host = db_host, port = db_port)
s <- paste0("select * from ", db_table)
rs <- dbSendQuery(mydb, s)
df <-  fetch(rs, n = -1)
Jobs = unique(df)


dbDisconnect(mydb)
Jobs = select(Jobs,Skills)
Jobs$ID = row.names(Jobs)


Skills = cSplit(Jobs, "Skills", ",")
SkillWords <- melt(Skills, id.vars = c("ID"))
SkillWords = select(SkillWords,ID,value)
SkillWords = SkillWords %>% drop_na("value")
SkillWords$value = tolower(SkillWords$value)
#SkillWords = unique(SkillWords)

print("Mapping skills to synonyms")
#Remove commonwords from the dataframe
SkillWords$value = tolower(SkillWords$value)
SkillWords = anti_join(SkillWords,CommonWords,by = "value",all.x = TRUE,allow.cartesian=TRUE)
print(paste0('skill mapping started on ', Sys.time()))

#Data clean up
colnames(IgnoreListMainCluster) = c('value')
SkillWords = anti_join(SkillWords, IgnoreListMainCluster,on = 'value')
SkillWords$Skill = str_replace(SkillWords$value,'and ','')
SkillWords = select(SkillWords,ID,Skill)
colnames(SkillWords) = c('ID','value')

#First level of clean up based on string starts with
t1 = SkillMapping_L1(SkillWords)
MappedtoCount = t1 %>% group_by(L1)%>%summarise(MappedWordCount=sum(TotalOccurance))
colnames(MappedtoCount) = c('MappedTo','Count')
SkillMap1 = select(t1,Skill,L1)
colnames(SkillMap1) = c('Word','MappedTo')
#Second level of clean up using levenstein similarity
SkillMap2 =SkillMapping_L2(MappedtoCount)
SkillMap2 = select(SkillMap2,Word,MappedTo)
 
# Remove the mapping that are covered in second level cleanup and append second level cleanup tp first level clean up
SkillMap = subset(SkillMap1, !Word %in% as.list(SkillMap2$Word))
SkillMap = rbind(SkillMap,SkillMap2)


print(paste0('skillmapping over on ', Sys.time()))
#Incorporate Synonyms
SkillMap = merge(SkillMap, Synonyms, by.x = 'MappedTo', by.y = 'Words', all.x = TRUE,allow.cartesian=TRUE)
SkillMap$L1 <- ifelse(is.na(SkillMap$Synonym), SkillMap$MappedTo, SkillMap$Synonym)   
SkillMap = select(SkillMap,Word,MappedTo)

#Get the mapped skill
SkillWords = merge(SkillWords,SkillMap,by.x='value',by.y='Word',all.x=TRUE,allow.cartesian=TRUE)
SkillWords = subset(SkillWords,value!='')
SkillWords = select(SkillWords,ID,MappedTo)

#Remove rows with value as None and empty from frame
SkillWords = subset(SkillWords,MappedTo!='')
SkillWords = unique(SkillWords)



colnames(IgnoreListMainCluster) = c('MappedTo')
SkillWords = anti_join(SkillWords, IgnoreListMainCluster,on = 'MappedTo')

print(paste0('Cooccurance calculation started',Sys.time()))
#Get the cooccurance of the skills
SkillCo_occurance = CreateCooccuranceMatrix(SkillWords)
SkillCoOccurance_Pivot = SkillCo_occurance %>% group_by(Skill.x) %>% summarise(AssociatedSkillSpread=n())
colnames(SkillCoOccurance_Pivot) = c('Skill','AssociatedSkillSpread')



print(paste0('Calculation started',Sys.time()))
#Calculate Total skill occurrance
Main_Cluster = SkillWords%>%group_by(MappedTo)%>%summarise(TotalOccurances=n())
colnames(Main_Cluster) = c('Skill','TotalOccurances')
SkillOccurrance = Main_Cluster
Main_Cluster = merge(Main_Cluster,SkillCoOccurance_Pivot,by='Skill',all.x=TRUE)
Main_Cluster = subset(Main_Cluster,!is.na(AssociatedSkillSpread))

Main_Cluster$WT_TotalOccurances = (Main_Cluster$TotalOccurances-min(Main_Cluster$TotalOccurances))/(max(Main_Cluster$TotalOccurances)-min(Main_Cluster$TotalOccurances))
Main_Cluster$WT_Spread = (Main_Cluster$AssociatedSkillSpread-min(Main_Cluster$AssociatedSkillSpread))/(max(Main_Cluster$AssociatedSkillSpread)-min(Main_Cluster$AssociatedSkillSpread))
Main_Cluster$WT_Total = Main_Cluster$WT_Spread+(Main_Cluster$WT_TotalOccurances*3)
Main_Cluster = Main_Cluster[!Main_Cluster$Skill %in% IgnoreListMainCluster ,]
#Main_Cluster = subset(Main_Cluster,TotalOccurances>=7 )

#Creating Skillnorm
Mapping_df = SkillCo_occurance
colnames(Mapping_df) = c('Skill','AssociatedSkill','CoOccurance')
Mapping_df = merge(Mapping_df,Main_Cluster,by='Skill',all.x = TRUE)
Mapping_df$CoOccurranceRatio = Mapping_df$CoOccurance/Mapping_df$TotalOccurances 
Mapping_df['CoOccurranceRatio'] = round(Mapping_df['CoOccurranceRatio'], 3)

NewSkillNorm = merge(Mapping_df,Main_Cluster,by.x ='AssociatedSkill',by.y='Skill',all.x=TRUE,allow.cartesian=TRUE)
NewSkillNorm = select(NewSkillNorm,AssociatedSkill,Skill,CoOccurance,TotalOccurances.x,WT_TotalOccurances.x,WT_Spread.x,WT_Total.x,CoOccurranceRatio,TotalOccurances.y,WT_TotalOccurances.y,WT_Spread.y,WT_Total.y)
colnames(NewSkillNorm) = c("AssociatedSkill","Skill","CoOccurance","TotalOcc_Skill","WT_TotalOcc_Skill","WT_Spread_Skill","WT_Total_Skill","CoOccurranceRatio","TotalOcc_AssSkill","WT_TotalOcc_AssSkill","WT_Spread_Assskill","WT_Total_AssSkill")
NewSkillNorm = subset(NewSkillNorm,TotalOcc_Skill>=7)
Main_Cluster = subset(Main_Cluster,TotalOccurances>=7)

print(paste0('Calculation completed on',Sys.time()))
mydb <-  dbConnect(MySQL(), user = db_user, password = db_password, dbname = db_name, host = db_host, port = db_port)
dbWriteTable(mydb, value = SkillMap, name = "skillmap", overwrite  = TRUE, row.names = FALSE )
dbWriteTable(mydb, value = Main_Cluster, name = "maincluster", overwrite  = TRUE, row.names = FALSE )
dbWriteTable(mydb, value = NewSkillNorm, name = "newskillnorm", overwrite = TRUE,row.names = FALSE )
dbDisconnect(mydb)
print(paste0('Saving completed on',Sys.time()))
