from Jobs_IT_new_v1 import ITJobs, SavetoDB
import pandas as pd, datetime
import sys
import os
from pathlib import Path
import concurrent.futures
from selenium import webdriver
from selenium.webdriver.chrome.options import Options


def startbatchJob(NewSkillCombination):
    JobsBySkill = pd.DataFrame()
    chrome_options = Options()
    chrome_options.add_argument("--headless")  # Run Chrome in headless mode

    for i, row in NewSkillCombination.iterrows():
        print(str(row['Row']) + ' out of ' + str(NewSkillCombination.shape[0]))
        f = open('jobsIT_New.log', 'a')
        f.writelines(row['SkillCombination'] + ' ')
        f.close()
        try:
            with webdriver.Chrome(options=chrome_options) as driver:
                Temp = ITJobs(row['SkillCombination'], driver)
                JobsBySkill = JobsBySkill.append(Temp)
        except Exception as e:
            print(e)

    start = datetime.datetime.now()
    SavetoDB(JobsBySkill)
    # print("jobsbylocation printing time: ", datetime.datetime.now()-start)
    return JobsBySkill



