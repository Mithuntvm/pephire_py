# import runner as r 
import subprocess
from subprocess import run, call,Popen
import threading 
# print(r.var)

a =1     
# if r.var <=10:
if a == 1:
    print('execute')
    
    b = ['1','3','job1.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading_Test.py']+ b,
                 start_new_session=True )
    print('execute 1')
    c = ['4','7','job2.xlsx']             
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading_Test.py']+ c,
                 start_new_session=True )
    print('execute 2')
    d=['8','-1','job3.xlsx']
    Popen(['python', 'C:\Pephire\Weekly Jobs\IT\BatchJobMultithreading_Test.py']+ d,
                 start_new_session=True )      
    

else:
    print('Condition not satisfied')





