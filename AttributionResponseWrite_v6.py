

import pymysql
import uuid
import pandas as pd

def isNullOrEmpty(s):
    return s is None or len(s.strip()) == 0


def generate_random_uuid():
    return str(uuid.uuid1())

def CheckStatus(ContactNumber,org_id):
    try:
        print('Entered Check Status Function')
       
        #Check if the number already exists for the given organization
        cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')
        cursor = cnx.cursor()
        
        sql= ""
        sql = "select * from pephire.candidates where phone = '"+ContactNumber+"' and organization_id = '"+str(org_id)+"' "
        cursor.execute(sql)
        print(sql)
        existing_candidate= cursor.fetchall()
        columnexisting_candidate = [desc[0] for desc in cursor.description]
        print('test')
        df_existing_candidate = pd.DataFrame(existing_candidate, columns=columnexisting_candidate)
        print (df_existing_candidate.shape[0])
        if df_existing_candidate.shape[0]>0:
            #check if the candidate id is in active state
            sql = ""
            sql = "select id from pephire.candidates where phone = '"+ContactNumber+"' and organization_id = '"+str(org_id)+"' "
            cursor.execute(sql)
            existing_id= cursor.fetchall()
            columnexisting_id = [desc[0] for desc in cursor.description]
            df_existing_id = pd.DataFrame(existing_id, columns=columnexisting_id)
            existing_id = df_existing_id['id'][0]
            
            sql = ""
            sql = "select * from pephire_trans.candidate_stages_v2 where id = '"+str(existing_id)+"' "
            cursor.execute(sql)
            active_id= cursor.fetchall()
            columnsactive_id = [desc[0] for desc in cursor.description]
            df_active_id = pd.DataFrame(active_id, columns=columnsactive_id)
            cursor.close()
            cnx.close()
            if df_active_id.shape[0]>0:
                #The candidate is active, do not update the details
                print('The candidate is in active state, therefore ignore the changes')
                return 'ActiveID'
            else:
                #Update the details in the candidate table for the existing id
                #Update candidate details
                active_id = existing_id
                return active_id
            
        else:
            #responsewrite
            print('The candidate is new so insert the details to the respective tables')
            return 'NewResume'
    except:
        cursor.close()
        cnx.close()
        
        
def UpdateCandidatedetails(active_id,df_Response,ResumeID):
    try:
        #Create connection
        cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')
        cursor = cnx.cursor()
        
        #Insert to tables
        for index, rw in df_Response.iterrows():
            Name = rw['Name']
            Email= rw['Email']
            DOB = rw['DOB']
            Passport = rw['Passport']
            Visa = rw['Visa']
            Experience = rw['Experience']
            Education = rw['Education']
            Role = rw['Role']
            Roles_tagged = rw['Roles_Tagged']
            LinkedIn = rw['LinkedIn']
            RoleCategory = rw['RoleCategory']
            #Insert into candidates table
            sql = ""
            sql = "update pephire.candidates set name = '"+Name+"',resume_id = '"+str(ResumeID)+"',email='"+Email+"',dob='"+DOB+"',passport_no = '"+Passport+"', visatype = '"+Visa+"', experience = '"+str(Experience)+"', education='"+Education+"',linkedin_id = '"+LinkedIn+"',role ='"+Role+"',role_category='"+RoleCategory+"',updated_at = now() where id = '"+str(active_id)+"' "
            
            cursor.execute(sql)
            cnx.commit()
            
            #Update candidate_tags
            
            # Convert the data to a DataFrame
            tag_score_pairs = Roles_tagged.split('|')
            tags = []
            scores = []
            
            for pair in tag_score_pairs:
                tag, score = pair.split('<>')
                tags.append(tag)
                scores.append(int(score))
            
            # Create a DataFrame from the lists
            df_roles_Tagged = pd.DataFrame({'tags': tags, 'score': scores})
            df_roles_Tagged['candidate_id'] = active_id
            sql = ""
            sql = "delete from pephire.candidate__tags where candidate_id = '"+str(active_id)+"'"
            cursor.execute(sql)
            cnx.commit()
            for i, row in df_roles_Tagged.iterrows():
                
            
                sql = ""
                sql = "insert into pephire.candidate__tags values('','"+str(row['candidate_id'])+"','0','"+str(row['score'])+"',NULL,now(),NULL,'"+row['tags']+"')"
                
                cursor.execute(sql)
                cursor.commit()
            
            #Insert into candidate_skills
            
            Skills = rw['SkillIdentified']
            # Split the string and create a list of tuples (skill, score)
            Skill_list = Skills.split('|')
            
            skills = [item.split('<>')[0] for item in Skill_list]
            scores = [float(item.split('<>')[1]) for item in Skill_list]
            
            # Create a DataFrame from the lists
            df_Skills = pd.DataFrame({'skills': skills, 'score': scores})

            df_Skills['candidate_id'] = active_id
            sql = ""
            sql = "delete from pephire.candidateskills where candidate_id = '"+str(active_id)+"'"
            cursor.execute(sql)
            cnx.commit()
            for i, row in df_Skills.iterrows():
                
            
                sql = ""
                sql = "insert into pephire.candidateskills values('','"+str(row['candidate_id'])+"','0','"+str(row['score'])+"',NULL,now(),NULL,'"+row['skills']+"')"
                
                cursor.execute(sql)
                cursor.commit()
    
            
            #Insert into candidatesubskills
            
            SubSkills = rw['SubSkillIdentified']
            SubSkill_list = Skills.split('|')
            
            Subskills = [item.split('<>')[0] for item in SubSkill_list]
            scores = [float(item.split('<>')[1]) for item in SubSkill_list]
            
            # Create a DataFrame from the lists
            df_SubSkills = pd.DataFrame({'Subskills': Subskills, 'score': scores})
            df_SubSkills['candidate_id'] = active_id
            sql = ""
            sql = "delete from pephire.candidatesubskills where candidate_id = '"+active_id+"'"
            cursor.execute(sql)
            cnx.commit()
            for i, row in df_SubSkills.iterrows():
                
            
                sql = ""
                sql = "insert into pephire.candidatesubskills values('','"+str(row['candidate_id'])+"','"+row['Subskills']+"','0','"+str(row['score'])+"',NULL,now(),NULL)"
                
                cursor.execute(sql)
                cursor.commit()
    
        cursor.close()
        cnx.close()
        print('active_id')
        print (active_id)
        return active_id
    except:
        cursor.close()
        cnx.close()
    
def responsewrite(df_Response,ResumeID,UploadSource):
    print('Entered response write function')
#Write tables to 
# a.	candidates
# d.	candidate__tags
# e.	candidateskills
# f.	candidatesubskill


    try:
        #Create connection
        cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')
        cursor = cnx.cursor()
        print('Write to candidates table')
        #Insert to tables
        for index, rw in df_Response.iterrows():
            org_id = rw['organization_id']
            user_id = rw['user_id']
            cuno = '001'
            random_Candidateid = generate_random_uuid()
            Name = rw['Name']
            Email= rw['Email']
            Contact = rw['Contact']
            if type(Contact) != str:
                Contact = str(Contact)
            cleaned_PhoneNum = ''.join(filter(str.isdigit, Contact))
            if len(cleaned_PhoneNum) <= 10:
                cleaned_PhoneNum = '91' + cleaned_PhoneNum

            DOB = rw['DOB']
            Passport = rw['Passport']
            Visa = rw['Visa']
            Experience = rw['Experience']
            Sex = rw['Sex']
            Married = rw['Marital_Status']
            Education = rw['Education']
            Role = rw['Role']
            Roles_tagged = rw['Roles_Tagged']
            LinkedIn = rw['LinkedIn']
            missingfields = rw['missingfields']
            RoleCategory = rw['RoleCategory']
            Skills = rw['SkillIdentified']
            SubSkills = rw['SubSkillIdentified']
            location = rw['Location']
            Company = rw['Companies']
            Marital_Status = rw['Marital_Status']
            Engage = rw['Engage']
            Productivity = rw['Productivity']
            Corporateculture =  rw['Corporateculture']
            Strengths = rw['Strengths']
            #Insert into candidates table
            is_any_null_or_empty = isNullOrEmpty(SubSkills) or isNullOrEmpty(Skills) or isNullOrEmpty(Roles_tagged) 
            if is_any_null_or_empty:
                candidate_id = ''
            else:
                try:
                    sql = ""
                    sql = """insert into pephire.candidates values ("", '"""+random_Candidateid+"""', '"""+cuno+"""', '"""+str(org_id)+"""', '"""+str(user_id)+"""', '"""+str(ResumeID)+"""', '"""+Name+"""', NULL, '"""+Email+"""', '"""+cleaned_PhoneNum+"""', '"""+DOB+"""', '"""+Passport+"""', '"""+Visa+"""', NULL, '"""+str(Experience)+"""', '"""+Sex+"""', '"""+Married+"""', \""""+Education+"""\", NULL, "", '"""+LinkedIn+"""', '"1"', '"""+Company+"""', '"""+Role+"""', '"""+RoleCategory+"""', '"""+Engage+"""', '"""+Productivity+"""', '"""+Corporateculture+"""', '"""+Strengths+"""', NULL, NULL, NULL, NULL, '"0"', '"1"', '"0"', '"0"', '"0"', '"""+missingfields+"""', NULL, '"0"', NULL, now(), NULL, NULL, NULL, NULL, NULL,NULL,NULL, NULL, '"4"', '"0"', NULL,'"""+UploadSource+"""')"""
                    print(sql)
                    cursor.execute(sql)
                    cnx.commit()
                    print('Candidate table write complete')
                except:
                    print('Error writing to candidates table')
                    cursor.close()
                    cnx.close()
                print('Write to tags table')
                #Select candidate id from candidates table and inset roles tagged with the scores to the table 
                sql = ""
                sql = "select id from pephire.candidates where phone = '"+cleaned_PhoneNum+"' "
                cursor.execute(sql)
                identifier= cursor.fetchall()
                columnscandidate_id = [desc[0] for desc in cursor.description]
                df_candidate_id = pd.DataFrame(identifier, columns=columnscandidate_id)
                candidate_id = df_candidate_id['id'][0]
                print(candidate_id)
                #Insert into candidate_tags
                # Split the string and create a list of tuples (skill, score)
                # data = Roles_tagged.str.split('|').explode().split('<>', expand=True)
                tag_score_pairs = Roles_tagged.split('|')
                tags = []
                scores = []
                
                for pair in tag_score_pairs:
                    tag, score = pair.split('<>')
                    tags.append(tag)
                    scores.append(int(score))
                
                # Create a DataFrame from the lists
                df_roles_Tagged = pd.DataFrame({'tags': tags, 'score': scores})
    
                
                df_roles_Tagged['candidate_id'] = candidate_id
                print(df_roles_Tagged)
                print('Write to tags table')
                for i, row in df_roles_Tagged.iterrows():
                    
                    try:
                       
                        sql = ""
                        sql = "insert into pephire.candidate__tags values('','"+str(row['candidate_id'])+"','0','"+str(row['score'])+"',NULL,now(),NULL,'"+row['tags']+"')"
                        
                        cursor.execute(sql)
                        cnx.commit()
                        
                        print('Completed write to candidate tags table')
                    except:
                        cursor.close()
                        cnx.close()
                        print('Error writing to candidate tags table')
                
                #Insert into candidate_skills
                
                Skills = rw['SkillIdentified']
                Skill_list = Skills.split('|')
                
                skills = [item.split('<>')[0] for item in Skill_list]
                scores = [float(item.split('<>')[1]) for item in Skill_list]
                
                # Create a DataFrame from the lists
                df_Skills = pd.DataFrame({'skills': skills, 'score': scores})
    
                df_Skills['candidate_id'] = candidate_id
                print('Write to skills table')
                for i, row in df_Skills.iterrows():
                    
                    try:
                        sql = ""
                        sql = "insert into pephire.candidateskills values('','"+str(row['candidate_id'])+"','0','"+str(row['score'])+"',NULL,now(),NULL,'"+row['skills']+"')"
                        print(sql)
                        cursor.execute(sql)
                        cnx.commit()
                        print('Write to candidate skills table complete')
                    except:
                         print('Error writing to candidate skills table')
                         cursor.close()
                         cnx.close()
        
                
                #Insert into candidatesubskills
                
                SubSkills = rw['SubSkillIdentified']
                SubSkill_list = Skills.split('|')
                
                Subskills = [item.split('<>')[0] for item in SubSkill_list]
                scores = [float(item.split('<>')[1]) for item in SubSkill_list]
                
                # Create a DataFrame from the lists
                df_SubSkills = pd.DataFrame({'Subskills': Subskills, 'score': scores})
                df_SubSkills['candidate_id'] = candidate_id
                print('Write to subskills table')
                for i, row in df_SubSkills.iterrows():
                    
                    try:
                        sql = ""
                        sql = "insert into pephire.candidatesubskills values('','"+str(row['candidate_id'])+"','"+row['Subskills']+"','0','"+str(row['score'])+"',NULL,now(),NULL)"
                        print(sql)
                        cursor.execute(sql)
                        cnx.commit()
                        print('Write to candidate subskills table complete')
                        
                    except:
                        print('Error writing to candidate subskills table complete')
                        cursor.close()
                        cnx.close()
                        
            cursor.close()
            cnx.close()
            return candidate_id
            print('Write complete')
    except:
        cursor.close()
        cnx.close()
        
        
def responsewriteFailed(df_Response,ResumeID,UploadSource,FileName):
    print('Entered response write Failed function')
    print(df_Response)
#Write tables to 
# a.	candidates
# d.	candidate__tags
# e.	candidateskills
# f.	candidatesubskill


    try:
        #Create connection
        cnx = pymysql.connect(user='pephire@pepmysql', password='Nopassword4you',host='pepmysql.mysql.database.azure.com', database='pephire')
        cursor = cnx.cursor()
        print('Write to candidates table')
        print(df_Response)
        #Insert to tables
        for index, rw in df_Response.iterrows():
            print(df_Response)
            org_id = rw['organization_id']
            user_id = rw['user_id']
            cuno = '001'
            random_Candidateid = generate_random_uuid()
            
            #Insert into candidates table
            try:
                sql = ""
                sql = "insert into pephire.candidates values ('', '"+random_Candidateid+"', '"+cuno+"', '"+str(org_id)+"', '"+str(user_id)+"', '"+str(ResumeID)+"', '"+FileName+"', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1', '0', NULL, NULL, '', '', '', '', NULL, NULL, NULL, NULL, '0', '1', '0', '1', '1', NULL, NULL, '0', NULL, now(), NULL, NULL, NULL, NULL, NULL,NULL,NULL, NULL, '4', '0', NULL,'"+UploadSource+"')"
                print(sql)
                cursor.execute(sql)
                cnx.commit()
                print('Candidate table write for failed resume complete')
            except:
                print('Error writing to candidates table')
                cursor.close()
                cnx.close()
            
        cursor.close()
        cnx.close()
        print('Write complete')
    except:
        cursor.close()
        cnx.close()