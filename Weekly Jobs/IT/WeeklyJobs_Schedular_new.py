import pandas as pd
from BatchJobMultithreading_new import startbatchJob
import concurrent.futures
from Jobs_IT_new_v1 import  SavetoDB




def WeeklyService():
    NewSkillCombination = pd.read_excel(r'SearchQry.xlsx', sheet_name='Sheet2')

    # Split the DataFrame into 6 equal parts
    df_NewSkillCombination = [NewSkillCombination.iloc[i:i + len(NewSkillCombination) // 6] for i in range(0, len(NewSkillCombination), len(NewSkillCombination) // 6)]

    # Create a ProcessPoolExecutor with 6 processes
    num_processes = 6
    result = pd.DataFrame()
    with concurrent.futures.ProcessPoolExecutor(max_workers=num_processes) as executor:
        # Use the map method to concurrently call the function with each DataFrame part
        results = list(executor.map(startbatchJob, df_NewSkillCombination))

    print('Processes started')
    result = pd.DataFrame()
    for i, df_NewSkill in enumerate(results):
        file_name = f'output_part_{i+1}.xlsx'
        print(df_NewSkill)
        print(type(df_NewSkill))
        df_NewSkill.to_excel(file_name, index=False)
        print(f"DataFrame part saved to {file_name}.")
        result = result.append(df_NewSkill)

    return result
