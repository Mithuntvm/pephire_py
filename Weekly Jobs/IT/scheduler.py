# import runner as r 
import subprocess
from subprocess import run, call,Popen
import threading 
import os
# print(r.var)
if os.path.isfile('job1.xlsx'):
    os.remove('job1.xlsx')
if os.path.isfile('job2.xlsx'):
    os.remove('job2.xlsx')
if os.path.isfile('job3.xlsx'):
    os.remove('job3.xlsx')
if os.path.isfile('job4.xlsx'):
    os.remove('job4.xlsx')
if os.path.isfile('job5.xlsx'):
    os.remove('job5.xlsx')
if os.path.isfile('job6.xlsx'):
    os.remove('job6.xlsx')    
a =1     
# if r.var <=10:
if a == 1:
    print('execute')
    # subprocess.call(['python', 'C:\Pephire\Weekly Jobs\IT\execute.py'])
    # print('sad')
    # subprocess.call(['python', 'C:\Pephire\Weekly Jobs\IT\execute1.py'])
    b = ['1','50','job1.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ b,
                 start_new_session=True )
    print('execute 1')
    c = ['51','100','job2.xlsx']             
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ c,
                 start_new_session=True )
    print('execute 2')
    d=['101','150','job3.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ d,
                 start_new_session=True )      
    e=['151','200','job4.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ e,
                 start_new_session=True )
    f=['201','250','job5.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ f,
          start_new_session=True )  
    g=['251','-1','job6.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ g,
                 start_new_session=True )      
    
          
    

else:
    print('Condition not satisfied')