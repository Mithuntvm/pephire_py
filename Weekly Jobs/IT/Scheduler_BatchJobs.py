# import runner as r 
import subprocess
from subprocess import run, call,Popen
import threading 
# print(r.var)

a =1     
# if r.var <=10:
if a == 1:
    print('execute')
    # subprocess.call(['python', 'C:\Pephire\Weekly Jobs\IT\execute.py'])
    # print('sad')
    # subprocess.call(['python', 'C:\Pephire\Weekly Jobs\IT\execute1.py'])
    b = ['1,','100,','job1.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ b,
                 start_new_session=True )
    print('execute 1')
    c = ['101,','201,','job2.xlsx']             
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ c,
                 start_new_session=True )
    print('execute 2')
    d=['201,','301,','job3.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading.py']+ d,
                 start_new_session=True )      
    

else:
    print('Condition not satisfied')


