# -*- coding: utf-8 -*-
###Cleaned and commented code of PrResume5-WithRelTxtNPatternWithFindingAreas2.py
##----------------Import all the required libraries--------------------------##
import locale
locale.getdefaultlocale()
import pandas as pd
from shutil import copyfile
from nltk.corpus import stopwords
from difflib import SequenceMatcher
import re,subprocess,os,docxpy,spacy,PyPDF2
src_pdftotxt = r'C:\Pephire\pdftotext.exe'
##----------------Define all the required lists and corpus-------------------##
#Define the list of stop words
stop = list(set(stopwords.words('english'))) + [',','.','/',';',':','-','+','=','(',')','[',']','{','}','*','&','&','^','%','#','@','!','~','`']
stopchars = ['architect','employer','description','jobs','job','experience','client','jan','feb','mar','apr','may','jun','jul','aug','sep','sept','oct','nov','dec','january','february','march','april','june','july','august','september','november','december']
characs = [',','/',';',':','-','+','=','(',')','[',']','{','}','*','&','&','^','%','#','@','!','~','`']

#Load nlp model for named entity recognition
nlp = spacy.load("en_core_web_sm")
#Set of end words for checking whether the output of NLP named entity recognition is valid  
pattern = re.compile(r'(ltd)\.?$|(limited)\.?$|(inc)\.?$|(corp)\.?$|(corporation)\.?$|(incorporated)\.?$|(llp)\.?$|(limited\sliability\scompany)$|(l\.l\.c)\.?$|(co)\.?$|(club)$|(fund)$|(society)$|(union)$|(syndicate)$') #Patterns to be identified
#List of required tail words        
TailWords = ['Limited\sLiability\sCompany','LLC','L\.L\.C','Inc','Incorporated','Corp','Corporation','Co','Company','Ltd','Limited','Group']#,'Club','Foundation','Fund','Society','Union','Syndicate'
#Company corpus creation
Companies = pd.read_excel("Companies.xlsx")
CompanyList = list(Companies['org'].str.lower())
#Skillwords corpus creation
skillwords = pd.read_csv("SkillWords.csv")
SkillList1 = list(skillwords['KeyWord'].str.lower())
SkillList2 = list(skillwords['Skill'].str.lower())
SkillList = set(SkillList1 + SkillList2)
#List to store all file names that were not opened
notopened = []        
##----------------------Define all the functions-----------------------------##
##Function to get contents of pdf file
def getPDFTextasTxt(src_pdftotxt,FileName):
    txtFile = FileName
    txtFile = re.sub('.pdf','',txtFile)  
    Folderpath = os.path.dirname(FileName)
    dst = Folderpath + "\\pdftotext.exe"
    if(os.path.exists(dst)==False):
        copyfile(src_pdftotxt, dst) 
    subprocess.call([Folderpath + '\\pdftotext', FileName, txtFile+".txt"])
    text = open(txtFile+".txt",'r').read() 
    return text
##Function to get contents of docx file
def getDocxText(filename):
    return docxpy.process(filename)
##Function to check similarity between two strings using Sequence Matcher
def similar(a, b):
    return SequenceMatcher(None, a, b).ratio()
##Function to find the relevant text from  input text
def getRelevantText(txt):
    TxtList = txt.split()
    #List words that has an year pattern in the given text
    w1 = re.findall(r'[21][0-9]{3}',txt.lower())
    #List words denoting year in the given text
    w2 = re.findall(r'year\'?s?\'?|yr\'?s?\'?',txt.lower())
    #Combine both lists into one and tke its unique
    w1 = w2 + w1
    w1 = list(set(w1))
    #Find phrases with n number of words to either side of the words in the above mentioned list and store the result in a list
    for i,j in enumerate(w1):
        w2 = w2 + list(set(re.findall(r'\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?[^\s]+?\s+?'+re.escape(j)+r'\s?[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+' ,txt))) #search for 'year' and dates
    
    '''
    for i,word in enumerate(w1):
        for j,x in enumerate(w):
            if word in x.lower():
                w2.append(' '.join(w[j-17:j+17]))#Get different lists denoting presence of a company name(as-in combo, in-as combo, as-at combo, at-as combo, as-with combo, ending with limited etc)
    '''
    w3 = [] + list(set(re.findall(r'\sas\s[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\sin\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+' ,txt, re.IGNORECASE)))            #as - in combo
    w4 = [] + list(set(re.findall(r'\sin\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?as\s' ,txt, re.IGNORECASE)))  #in-as combo
    w5 = [] + list(set(re.findall(r'\sas\s[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\sat\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+' ,txt, re.IGNORECASE)))           #as-at combo
    w6 = [] + list(set(re.findall(r'\sat\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?as\s' ,txt, re.IGNORECASE)))  #at-as combo
    w7 = [] + list(set(re.findall(r'\sas\s[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\swith\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+\s[^\s]+' ,txt, re.IGNORECASE)))        #as-with combo 
    w8 = [] + list(set(re.findall(r'\swith\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?as\s' ,txt, re.IGNORECASE)))  #with-as combo
    #Gets all phrases with the said keywords
    keywords = ['Pvt','Ltd','Limited']
    w9 = []
    for i,word in enumerate(keywords):
        for j,x in enumerate(TxtList):
            if word.lower() in x.lower():
                w9.append(' '.join(TxtList[j-8:j])+" "+word)
    
    #Combine all these phrases lists into one list and join all of them to form a string 
    Phrases = w3 + w2 + w4 + w5 + w6 + w7 + w8 + w9
    try:
        Phrases.remove("")
    except:
        pass
    #Remove phrases that begin with words mentioned in patterns(pvt,ltd etc)
    ToBeRemoved = []
    for i,word in enumerate(Phrases):
        a = word.split()
        if re.search(pattern,a[0].lower()):
            ToBeRemoved.append(word)
    Phrases = [r for i, r in enumerate(set(Phrases)) if r not in set(ToBeRemoved)]
    result = ' '.join(Phrases) 
    return result
##Function for initial text cleaning
def TextModifications(txt):
    txt = txt.replace('\.',' ')                             #Replacing \n with \s
    txt = txt.replace('\n',' ')                             #Replacing \n with \s
    txt = re.sub(r'\s+',' ',txt)                           #Replacing multiple spaces with single space
    txt = re.sub(r'[^\x00-\x7F]+',' ', txt)                #Replacing multiple spaces with single space for unicode
    txt = re.sub(r'([a-zA-Z]+)\-([a-zA-Z]+)',r'\1\2',txt)  #Word1-Word2 to Word1Word2
    return txt
##Function will return true if there is not even one character that is an alphabet or a number     
def spec(s):
        if not re.match(r'^[_\W]+$', s):
            return False
        else:
            return True
##Function to return only a part of phrase that satisfies a particular set of conditions
def PatternAvoidingTagger(org,flag):
    result = []
    #Iterate through the phrases, split each of them into words and iterate through those words, delete the part of phrase upto the first encounter of a word that starts with lowercase, doesnt contain any word characters or is in the set of keywords(engineer, job, employer etc)
    for i in org:
        a = i.split() 
        index = 0
        found = 0
        for j,word in enumerate(a):
            if flag == 1:
                if (word.islower() and word != 'and') or spec(word.lower()) or word.lower() == 'company' or word.lower() == 'experience' or word.lower() == 'description' or word.lower() == 'location' or word.lower() == 'job' or word.lower() == 'job' or word.lower() ==  'engineer' or word.lower() ==  'employer' or word.lower() == 'designation' or word.lower() == 'duration' or word.lower().isnumeric() or ":" in word or ',' in word or any([s in word[1:] for s in characs]) or ('.' in word and ('pvt' not in word.lower() and 'ltd' not in word.lower())) or word.lower() in stop or word.lower() in stopchars:
                    index = j
                    found = 1
            else:
                if (word.islower() and word != 'and') or word.lower() == 'company' or word.lower() == 'experience' or word.lower() == 'description' or word.lower() == 'job' or word.lower() == 'location' or word.lower() ==  'engineer' or word.lower() ==  'employer' or word.lower() == 'designation' or word.lower() == 'duration' or word.lower().isnumeric() or ":" in word or word.lower() in stopchars:
                    index = j
                    found = 1
        if found == 1:
            del a[0:index+1]   
        result.append(' '.join(a)) 
    #Keep only unique findings of result and remove all duplicates: Keep all the indices of duplicates to a list and delete them in one go
    Duplicates = []
    for i in range(len(result)-1):
        for j in range(i+1,len(result)):
            if similar(result[i].lower(),result[j].lower())> 0.8:
                if len(result[i]) >= len(result[j]):
                    Duplicates.append(j)
                else:
                    Duplicates.append(i)
    result = [r for i, r in enumerate(result) if i not in set(Duplicates)]
    return(list(set(result)))


##Function to identify from the text all phrases(company names) that ends with the above defined set of tailwords that indicate the presence of a company        
def PatternIdentification(txt):
    org = []
    #Find all phrases that contain n number of words preceding the defined Stopwords
    for i in set(TailWords):
        org = org + re.findall(r'[^\s]+?\s?[^\s]+?\s?[^\s]+?\s?\s?[^\s]+?\s?[^\s]+?\s'+i+'\.?\s' ,txt,re.IGNORECASE)#ltd
    return(PatternAvoidingTagger(org,1))
##Function to extract company names from resumes
def ResumeExtraction(CleanedTxt,name):
    orgListVerified = []
    #----------------------With Named entity recognition----------------------#
    doc = nlp(CleanedTxt)
    orgList = []
    #Check for label "ORG" or "PERSON" in named entities and store those words to orgList  
    for entity in doc.ents:
        if entity.text != " ":
            if entity.label_ == "ORG" or "PERSON" :
                orgList.append(entity.text)
    #----------------Getting relevant text based on conditions----------------#
    RelTxt = getRelevantText(CleanedTxt)
    WordsFound = []
    #-------------Filter orgList using Skillset and relevant text-------------#
    #Eliminate the words in SkillList
    for i in orgList:
        if i.lower() not in SkillList:
            WordsFound.append(i)
    #Eliminate the words not around relevant text
    for a in WordsFound:
        if a.lower() in RelTxt.lower():
            if re.search(pattern,a.lower()) or a.lower() in CompanyList:
                orgListVerified.append(a)
    for i,word in enumerate(CompanyList):
        if word.lower() == "able":
            print(i)
    #Remove unwanted patterns in the set of phrases : Call function PatternAvoidingTagger
    orgListVerified = PatternAvoidingTagger(orgListVerified,0)
    #Remove duplicates within orgListVerified
    orgListVerified = list(set(orgListVerified))
    dicts = [{'Name': name, 'org': o,"Status": "Found","Method":"Tagger"} for o in orgListVerified]
    #-------------Without tagger and appending the final result---------------#  
    #PatternList contains the duplicate removed output from PatternIdentification function
    PatternList = list(set(PatternIdentification(RelTxt)))
    #---------------------------Remove Duplicates-----------------------------#
    #Check for words in PatternList that also occur in orgListVerified and remove them from PatterList
    Duplicates = []
    for i in range(len(PatternList)):
        for j in orgListVerified:
            if similar(PatternList[i].lower(),j.lower()) > 0.8:
                Duplicates.append(PatternList[i])
    PatternList = [r for i, r in enumerate(set(PatternList)) if r not in set(Duplicates)]
    dicts2 = [{'Name': name, 'org': o,"Status": "Found", "Method":"Pattern"} for o in PatternList]
    return(dicts + dicts2)


def CompanyExtraction(name):
    FinalList = []
    ##------------------------Processing of each Input file----------------------##
    #Check whether input is a pdf
    if name.endswith(".pdf"):
        try:
            #print(name)
            #------------------------Read pdf file----------------------------#
            pdfFileObj = open(name, 'rb') 
            try:
                pdfReader = PyPDF2.PdfFileReader(pdfFileObj)
                NumPages = pdfReader.numPages
                txt = ""
                for i in range(0,NumPages):
                    pageObj = pdfReader.getPage(i) 
                    text = (pageObj.extractText()) 
                    txt = txt+" "+text
                txt = ''.join([i if ord(i) < 128 else '' for i in txt])
                pdfFileObj.close()
            except:
                return('')
            if len(txt)<100:
                return('')
            #txt = getPDFTextasTxt('E:\ResumeExtraction\Resumes\pdftotext.exe',name)
            #----------------------Text Modifications-------------------------#
            CleanedTxt = TextModifications(txt)
            #--------Call ResumeExtraction & Combine all the results----------#
            FinalList = FinalList + ResumeExtraction(CleanedTxt,name)
        except:
            notopened.append(name)
            pass
    elif name.endswith(".docx"):
        try:
            #print(name)
            try:
                txt = getDocxText(name)
            except:
                return('')
            if len(txt)<100:
                return('')
            #----------------------Text Modifications-------------------------#
            CleanedTxt = TextModifications(txt)
            #--------Call ResumeExtraction & Combine all the results----------#
            FinalList = FinalList + ResumeExtraction(CleanedTxt,name)
        except:
            notopened.append(name)
            pass
           
    df = pd.DataFrame(FinalList)
    ##---------------------Tail words and duplicates removal---------------------##
    #-----------------------Code to remove tail words-----------------------------#
    TailWordsDeletion = ['pvt ltd','p ltd','ltd','limited','private limited','llp','corp','corporation']
    index = [] 
    for i,j in df.iterrows():
        for k in TailWordsDeletion:
            if similar(j['org'].lower(),k)>0.8 or j['org']=='' or j['org']=='none':
                index.append(i)
    df = df.drop(list(set(index)))
    #---------------------------Duplicate Removal---------------------------------#
    #Take each findings of each document. Take first word. Store it in next column. Check similarity of words in this. If similar remove duplicates
    DfFinal = pd.DataFrame()
    try:
        for name in set(df.Name):
            #print(name)
            TempDf = df[df.Name == name].reset_index()
            TempDf['FirstWord'] = TempDf['org']
            TempDf['FirstWord'] = TempDf['FirstWord'].str.split(' ', 1)
            for index, row in TempDf.iterrows():
                TempDf.at[index,'FirstWord']=TempDf['FirstWord'][index][0].lower()
            #Uncomment the following three lines to print the name of files having duplicates 
            #a = TempDf.FirstWord
            #import collections
            #print([item for item, count in collections.Counter(a).items() if count > 1])
            TempDf = TempDf.drop_duplicates(subset = 'FirstWord', keep = "last")
            DfFinal = DfFinal.append(TempDf)
        
        DfFinal = DfFinal[["Method","Name","org"]]  
        #------------------------------Write File-------------------------------------#
        DfCheck =   DfFinal
        DfCheck = DfCheck.drop('Method',1)
        DfCheck['org'] = DfCheck[['Name','org']].groupby(['Name'])['org'].transform(lambda x: ' | '.join(x))
        DfCheck = DfCheck.drop_duplicates().reset_index()
        return(DfCheck.org[0])
    except:
        return('')



