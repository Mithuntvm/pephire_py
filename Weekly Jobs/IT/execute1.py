# -*- coding: utf-8 -*-
"""
Created on Wed May  3 14:29:00 2023

@author: mithun
"""


import time
import sys
# time.sleep(10)
# print('Condition True')
i=0
while i<100:
    i = i + 1
    f = open('Nrefile2.txt','a')
    f.writelines(sys.argv[1:])
    f.writelines(str(i))
    f.close()
    time.sleep(10)