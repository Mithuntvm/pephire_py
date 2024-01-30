import pandas as pd
from datetime import datetime, timedelta

Month1 = datetime.now() - timedelta(days=30)
Month6 = datetime.now() - timedelta(days=180)
#------------------------------------------------------------------------------#
def topTable(Users, Scores, lasts):
    r1d3 = r2d3 = r3d3 = 'Unknown'
    if int(Scores['LI']) > 70:
        liurl = f"https://www.linkedin.com/in/{Users['LI']}"
        r1d1 = f'<a href = "{liurl}" target="_blank">' 
        r1d1 = r1d1 + f'LinkedIn</a>'
        r1d2 = f"{Scores['LI']}%"
    else:
        r1d1, r1d2 = 'LinkedIn', '0'
    if lasts['LI'] and int(Scores['LI']) > 70:
        if 'w' in lasts['LI'] or 'd' in lasts['LI']:
            r1d3 = 'High'
        elif lasts['LI']=='7mo':
            r1d3 = 'Low'
        else:
            r1d3 = 'Medium'
    if int(Scores['FB']) > 70:
        fburl = f"http://facebook.com/{Users['FB']}/"
        r2d1 = f'<a href = "{fburl}"target="_blank">'
        r2d1 = r2d1 + f'Facebook</a>'
        r2d2 = f"{Scores['FB']}%"
    else:
        r2d1, r2d2 = 'Facebook', '0'
        
    if lasts['FB'] and int(Scores['FB']) > 70:
        print(lasts['FB'])
        fbdt =  datetime.strptime(lasts['FB'], '%d/%m/%Y, %H:%M')
        if fbdt < Month1:
            r2d3 = 'High'
        elif fbdt < Month6:
            r2d3 = 'Medium'
        else:
            r2d3 = 'Low'
            
    if int(Scores['TW']) > 70:
        twurl = f"http://twitter.com/{Users['TW']}/"
        r3d1 = f'<a href = "{twurl}"target="_blank"> '
        r3d1 = r3d1 + f'Twitter</a>'
        r3d2 = f"{Scores['TW']}%"
    else:
        r3d1, r3d2 = 'Twitter', '0'
    
    if lasts['TW'] and int(Scores['TW']) > 70:
        if lasts['TW'] < Month1.date():
            r3d3 = 'High'
        elif lasts['TW'] < Month6.date():
            r3d3 = 'Medium'
        else:
            r3d3 = 'Low'
    
    row1 = ['<b>Source</b>','<b>Match Index</b>', '<b>Activity Level</b>']
    row2 = [r1d1, r1d2, r1d3]
    row3 = [r2d1, r2d2, r2d3]
    row4 = [r3d1, r3d2, r3d3]
    rows = [row1, row2, row3, row4]
    rows = ['</td> <td>'.join(r) for r in rows]
    rows = '</td> </tr> <tr> <td>'.join(rows)
    table = f'<table class="tftable"> <tr> <td>{rows}'
    table = f'{table} </td> </tr> </table>'
    
    table = table.replace('Low', '<font color="red">Low</font>')
    table = table.replace('High', '<font color="green">High</font>')
    table = table.replace('Medium', '<font color="yellow">Medium</font>')
    return table
#------------------------------------------------------------------------------#
def experio(username, Profile):
    expe = Profile['experience']
    fname = username[:username.find(' ')]
    
    if expe.empty:
        return 'Found no work records', ''
    
    location = None
    if 'Period' in list(expe):
        expe.Period = expe.Period.astype(str)
        curr = expe[expe.Period.str.contains('Present')]
        if 'Company' in curr:
            currw = curr['Company'].iloc[0]
        else:
            curr = ''
        currp = curr['Position'].iloc[0]
        currs = f'{username} currently works as a {currp} at {currw}, {location}.'
        items = expe[~expe.Period.str.contains('Present')]
        items = items.reset_index(drop=True)
    else:
        curr = pd.DataFrame()
        items = expe.reset_index(drop=True)
    if not curr.empty:
        if 'Location' in curr:
            location = list(curr['Location'])[0]
    if not location:
        if Profile['location']:
            location = Profile['location']
        else:
            location = 'No location details found.'

    if not items.empty:
        if not curr.empty:
            currs = f"{currs} Before joining {currw}, "
        else:
             currs = ''
        print(items.shape[0])
        for i, row in items.iterrows():
            rowt, rowd = "", ""
            rowp = row['Position']
            rowc = row['Company']
            if 'Period' in row:
                rowt = f" from {row['Period']}"
            #rowt = rowt.replace('–', 'to')
            if 'Duration' in row:
                rowd = f" for a period of {row['Duration']}"
            rows = f"{fname} worked at {rowc} as {rowp}{rowd}{rowt}."
            print(i)
            if i > 2 and i == items.shape[0] - 1:
                currs = f"{currs} And {rows}"
            else:
                currs = f"{currs}{rows}"
            print("Finished")
        
    return currs, location

def Grindelwald(username, crimes):
    if crimes.empty:
        return 'Found no criminal records'
    acts = []
    for i, row in crimes.iterrows():
        sect = row['Cr. Num & Section']
        station, date = row['Police Station'], row['Date & Time of Arrest']
        act = f"{sect} on {date} at {station}."
        acts.append(act)
    acts = ' '.join(acts)
    return f"{username} has arrested for following criminal activities:   {acts}"

def School(username, Profile):
    educ = Profile['education']
    if not educ.empty:
        if 'Period' in educ:
            educ = educ[~educ['Period'].isnull()]
        educ = educ.fillna('Unknown')
        courses = []
        for i,row in educ.iterrows():
            if 'Period' in row:
                rowp = row['Period']
                rowp = rowp.replace('–', 'to')
            else:
                rowp=''
            degree, field, insti = row['Degree'], row['Field'], row['School']
            if rowp:
                rows = f"From {rowp}, {degree} ({field}) at {insti}."
            else:
                rows = f"{degree} ({field}) at {insti}."
            courses.append(rows)
        return ' '.join(courses)
        return f"<b>Educational details of {username} is as follows</b>:  {courses}"
    else:
        return 'Found no Educational details'


def inter(username, interax):
    totalIn = ''
    if interax['Friends']:
        totalIn = totalIn + '<br/>' + f'Friends of {username} are: '
        totalIn = totalIn + '<br/>' + ', '.join(interax['Friends'])
    if interax['Follows']:
        totalIn = totalIn + '<br/>' + f'{username} follows: '
        totalIn = totalIn + '<br/>' + ', '.join(interax['Follows'])
    if interax['Followers']:
        totalIn = totalIn + '<br/>' + f'{username} followed by: '
        totalIn = totalIn + '<br/>' + ', '.join(interax['Followers'])
    if not totalIn:
        totalIn = 'Found None'
    return totalIn

def socTable(othdata, socdata):
    toptable = topTable(socdata['Users'], socdata['Scores'], socdata['Lasts'])
    if not socdata["Photo"]:
        photo = 'D:\SVN\ProfileExplorer\avatar.png'
    else:
        photo = socdata["Photo"]
    Foto = f'<center><img src="{photo}" tyle="width:100px">'
    Name = f"<br/><br/><b>{othdata['Name'].upper()}</b>"
    
    Header = Foto + Name + '</center><br/><br/>'
    
    if othdata['Net']:
        netdata, bdata = othdata['Net'], []
        for dt in range(len(netdata)):
            linkText = f'<li><i class="fa-li fa fa-square"></i><a href="{netdata[dt][0]}"'
            linkText += f' target="_blank">{netdata[dt][1]}</a></li>'
            bdata.append(linkText)
        bdata = ''.join(bdata)
        bdata = f'<ul class="fa-ul">{bdata}</ul>'
    else:
        bdata = 'Found None'
    
    bdata = f"<b>{othdata['Name'].title()}</b> in News:<br/> {bdata}"

    return Header + toptable + '<br/><br/>' + bdata

def desTable(othdata, socdata):
    Name = othdata['Name'].title()
    Interax = inter(Name, othdata['Inter'])
    Educate = School(Name, socdata['Profile'])
    Exp,Loc = experio(Name, socdata['Profile'])
    Crimina = Grindelwald(Name, othdata['Crime'])
    
    details = f'<ul class="list-group list-group-flush">'
    details += f'<li class="list-group-item"><b>Location</b>: {Loc}</li>'
    details += f'<li class="list-group-item"><b>Employment details</b>: {Exp}</li>'
    details += f'<li class="list-group-item"><b>Education details</b>: {Educate}</li>'
    details += f'<li class="list-group-item"><b>Personality Traits</b>: {othdata["MBT"]}</li>'
    details += f'<li class="list-group-item"><b>Top Interests</b>: {othdata["TopWords"]}</li>'
    details += f'<li class="list-group-item"><b>Interactions</b>: {Interax}</li>'
    details += f'<li class="list-group-item"><b>Criminal Records</b>: {Crimina}</li>'
    details += "</ul>"
    return details