# -*- coding: utf-8 -*-
"""
Created on Mon Nov  7 13:32:34 2022

@author: mithun
"""
#Difference b/w JDLibraries1 being getDOB, extDOB and extageDOB  taken from PepHire Server 1

import re, subprocess,time,cv2,os,docx2txt,shutil, win32com.client,docxpy

converterpath = r"C:\Program Files\PDF2DOCX-CL\PDF2DOCX-CL.exe"
def getDocxText(filename):
    return docxpy.process(filename)
def getPDFTextasTxt(FileName):
    destpath = re.sub('.pdf','.html',FileName)  
    subprocess.call(f'"{converterpath}" /src="{FileName}" /dst="{destpath}"', shell=True)
    docxpath = re.sub('.pdf','.docx',FileName)
    return getDocxText(docxpath)

def save_as_docx(path):
    w = win32com.client.Dispatch('Word.Application')
    doc=w.Documents.Open(path)
    time.sleep(3)
    new_file_abs = os.path.abspath(path)
    new_file_abs=new_file_abs.strip('.doc')+'.docx'
    doc.SaveAs(new_file_abs,FileFormat=16)
    doc.Close(False)
def getImage(file,outputpath):
    try:
        fileName = re.search(r'([a-zA-Z0-9]+)(\.[a-z]+)', file).group(1)
        result = [os.path.join(dp, f) for dp, dn, filenames in os.walk(outputpath) for f in filenames]
        resultFiles = [f for f in result if fileName in f]
        
        for f in resultFiles:
            os.remove(f)
    except:
        pass    
    txt=""
    try:
        if file.endswith(".pdf"):
            txt = extract_jpg_from_PDF(file,outputpath)
        elif file.lower().endswith(".docx"):
            if not file.endswith(".docx"):
                dst = re.sub(".{3}$",".docx",file) 
                os.rename(file, dst)
            txt = extract_jpg_from_docx(file,outputpath)
        elif file.lower().endswith(".doc"):
            save_as_docx(file)
            os.remove(file)
            file1 = re.sub(r'.doc',r'.docx',file)
            extract_jpg_from_docx(file1,outputpath)          
    except:
        txt=""
    return txt  
def extract_jpg_from_PDF(file,outputpath):
    try:
        os.mkdir(outputpath)
    except:
        pass
    pdf = open(file,'rb')
    pdf = pdf.read()
    startmark = b"\xff\xd8"
    startfix = 0
    endmark = b"\xff\xd9"
    endfix = 2
    i = 0
    writename = re.search(r'([^\\]+).pdf$',file).group(1)
    njpg = 1
    writelist = []
    while True:
        istream = pdf.find(b"stream", i)
        if istream < 0:
            #print("Y")
            break
        istart = pdf.find(startmark, istream, istream + 20)
        if istart < 0:
            #print("A")
            i = istream + 20
            continue
        iend = pdf.find(b"endstream", istart)
        if iend < 0:
            raise Exception("Didn't find end of stream!")
        iend = pdf.find(endmark, iend - 20)
        if iend < 0:
            raise Exception("Didn't find end of JPG!")

        istart += startfix
        iend += endfix
        #print("JPG %d from %d to %d" % (njpg, istart, iend))
        jpg = pdf[istart:iend]
        
        with open(f"{outputpath}\{writename}%d.jpg" % njpg, "wb") as jpgfile:
            jpgfile.write(jpg)
            writelist.append(jpgfile)
        if FaceRecognition(f"{outputpath}\{writename}%d.jpg" % njpg)!=0:
            return f"{outputpath}\{writename}%d.jpg" % njpg
        njpg += 1
        i = iend
    return "No Images"
def extract_jpg_from_docx(file,outputpath):
    writename = re.search(r'([^\\]+).docx$',file).group(1)
    # extract text
    #text = docx2txt.process(file)
    path = f'{outputpath}\{writename}'
    try:
        shutil.rmtree(path, ignore_errors=False, onerror=None)
    except:
        pass
    try:
        os.makedirs(path)
    except:
        pass
    # extract text and write images in /tmp/img_dir
    docx2txt.process(file, path) 
    outfiles = [filenames for (dirpath, dirnames, filenames) in os.walk(path)][0]
    writelist = []
    for i in outfiles:
        name = re.sub(r'image',writename,i)
        try:
            os.rename(f'{outputpath}\{writename}\{i}',f'{outputpath}\{name}')
        except:
            pass
        writelist.append(f'{outputpath}\{name}')
    try:
        os.removedirs(f'{outputpath}\{writename}')
    except:
        print("Reached pass")
    #shutil.rmtree(f'{outputpath}\{writename}', ignore_errors=False, onerror=None)
    for i in writelist:
        if (FaceRecognition(i)!= 0):
            return i
    return "No Images"
def FaceRecognition(imagePath):    
    cascPath = "haarcascade_frontalface_default.xml"
    faceCascade = cv2.CascadeClassifier(cascPath)
    image = cv2.imread(imagePath)
    gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    faces = faceCascade.detectMultiScale(
        gray,
        scaleFactor=1.1,
        minNeighbors=5,
        minSize=(30, 30),
        flags = cv2.CASCADE_SCALE_IMAGE
    )
    if len(faces)>0:
        return 1
    else:
        return 0
    print("Found {0} faces!".format(len(faces)))
    for (x, y, w, h) in faces:
        cv2.rectangle(image, (x, y), (x+w, y+h), (0, 255, 0), 2)    
    cv2.imshow("Faces found", image)
    cv2.waitKey(0)



