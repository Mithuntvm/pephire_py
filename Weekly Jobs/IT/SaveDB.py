from Jobs_IT_v1 import ITJobs, SavetoDB
import pandas as pd, datetime
import sys
import os
from pathlib import Path

import os, time
while True:
   filelist = ['job1.xlsx', 'job2.xlsx', 'job3.xlsx','job4.xlsx','job5.xlsx','job6.xlsx']
   if all([os.path.isfile(f) for f in filelist]):
       time.sleep(60)
       df_job1 = pd.read_excel('job1.xlsx')
       df_job2 = pd.read_excel('job2.xlsx')
       df_job3 = pd.read_excel('job3.xlsx')
       df_job4 = pd.read_excel('job4.xlsx')
       df_job5 = pd.read_excel('job5.xlsx')
       df_job6 = pd.read_excel('job6.xlsx')
       df_JobsBySkill = df_job1.append([df_job2, df_job3,df_job4,df_job5,df_job6])
       SavetoDB(df_JobsBySkill)
   else:
      time.sleep(300)


