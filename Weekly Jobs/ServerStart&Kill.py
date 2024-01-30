import psutil,os,time,datetime
nDelayinSec = 60*5
def LoadDatatoDB():
    return True
def StartServers():
    os.system('C:\ServersStart.bat')
    time.sleep(60*3)

def KillServers():
    for proc in psutil.process_iter():
        sProcess = proc.name()
        if(sProcess.startswith('python')):
            #print(proc.name())
            if sProcess == 'python.exe':
                print('Killing '+ sProcess)
                proc.kill()

def Start():               
    startTime = datetime.datetime.now()
    StartServers()
    while(True):
        currentTime = datetime.datetime.now()       
        diff = (currentTime - startTime).seconds  
        print('Time difference:'+ str(diff)+'sec')
        if (diff/nDelayinSec)>1:
            print('Restarting servers')
            LoadDatatoDB()
            try:
                KillServers()
            except:
                pass
            startTime = datetime.datetime.now()
            StartServers()
        time.sleep(60*5)
            
Start()