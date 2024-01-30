import psutil,os,time
from multiprocessing import Process
nDelaySec = 60*60*.25
def LoadDatatoDB():
    return True
def StartAttribution():
    os.system('python Attribution_API_v5.py') 
    while(True):
        time.sleep(nDelaySec)
        KillServers()
        os.system('python Attribution_API_v5.py') 
def StartRecommendation():
    os.system('python RecommendingProfiles_v5.py') 
    while(True):
        time.sleep(nDelaySec)
        KillServers()
        os.system('python RecommendingProfiles_v5.py')    
def StartFitment():
    os.system('python Fitment_API_v5.py') 
    while(True):
        time.sleep(nDelaySec)
        KillServers()
        os.system('python Fitment_API_v5.py')
def StartCompanyFind():
    os.system('python CompanyFind.py')  
    while(True):
        time.sleep(nDelaySec)
        KillServers()
        os.system('python CompanyFind.py') 
    
def StartServers():
    os.chdir('C:\Pephire')
    a = Process(target=StartAttribution)
    b = Process(target=StartRecommendation)
    c = Process(target=StartFitment)
    d = Process(target=StartCompanyFind)    
    a.start()
    b.start()
    c.start()
    d.start()  
    print('started')
    a.join()
    b.join()
    c.join()
    d.join()
    print('joined')
    return True

def KillServers():
    for proc in psutil.process_iter():
        sProcess = proc.name()
        if(sProcess.startswith('python')):
            #print(proc.name())
            if sProcess == 'python.exe':
                print('Killing '+ sProcess)
                proc.kill()
 
# =============================================================================
# def Start():               
#     startTime = datetime.datetime.now()
#     StartServers()
#     while(True):        
#         currentTime = datetime.datetime.now()
#         print(str(currentTime))
#         diff = currentTime - startTime
#         print('Time difference:', str(currentTime - startTime)) 
#         if (diff/(60*2)):
#             LoadDatatoDB()
#             KillServers()
#             StartServers()
# =============================================================================
        
if __name__ == '__main__':
    StartServers()