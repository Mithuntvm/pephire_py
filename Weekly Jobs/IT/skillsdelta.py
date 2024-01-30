import pandas as pd
import win32com.client as win32
from win32com.client import Dispatch
import os

def SendDeltaSkills(Subject,Message):
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    # mail.To = 'sanjna@sentientscripts.com;mithun@sentientscripts.com;priya@sentientscripts.com;sameer@sentientscripts.com'
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = Subject
    mail.Body = Message
    mail.Attachments.Add(os.path.join(os.getcwd(),'DeltaSkills.xlsx'))
    mail.Send()
def getNewSkills():
    import pandas as pd
    import pymysql
    from config import user_val, password_val,host_val,database_val,logFlag
    
    
    cnx = pymysql.connect(user=user_val, password=password_val, host=host_val, database=database_val)
    cursor = cnx.cursor()
    
    sql = """select Skill from pephire_static.newskillnorm """
    cursor.execute(sql)
    skill = cursor.fetchall()
    columns_skills = [desc[0] for desc in cursor.description]
    
    # Create a DataFrame from the fetched rows and column names
    df_skills = pd.DataFrame(skill, columns=columns_skills) 
    
    
    
    sql = """select AssociatedSkill from pephire_static.newskillnorm """
    cursor.execute(sql)
    Asscskill = cursor.fetchall()
    columns_Asscskill = [desc[0] for desc in cursor.description]
    # Create a DataFrame from the fetched rows and column names
    df_AsscSkill = pd.DataFrame(Asscskill, columns=columns_Asscskill) 
    
    
    cursor.close()
    cnx.close()
    
    df_skills = df_skills.drop_duplicates()
    df_AsscSkill = df_AsscSkill.drop_duplicates()
    
    df_AsscSkill.columns = ['Skill']
    
    df_Skills = pd.concat([df_skills,df_AsscSkill],ignore_index = True)
    
    df_Skills = df_Skills.drop_duplicates()
    return df_Skills

old_skills = pd.read_excel('oldSkills.xlsx')

new_skills = getNewSkills()

SkillsDelta = new_skills['Skill'][~new_skills['Skill'].isin(old_skills['Skill'])]
SkillsDelta.to_excel('DeltaSkills.xlsx')
SendDeltaSkills('Newly Added Skills','Please find attached excel with newly added skills')