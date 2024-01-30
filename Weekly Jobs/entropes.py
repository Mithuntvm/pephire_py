import pandas as pd
from fuzzywuzzy import fuzz
from bs4 import BeautifulSoup
import re, requests

def match(item, coms):
    item = item.lower()
    mat = False
    for com in coms:
        com = com.lower().replace('the','')
        com = com.replace('pvt','').replace('ltd', '').replace('.','').strip()
        if com in item:
            mat = True
            break
    return mat

def comURL(url, df):
    comps = list(df.Company)
    page = requests.get(url).text
    soup = BeautifulSoup(page,'html.parser')  
    pattern = re.compile(r"^https://www.zaubacorp.com/company/.+")
    links = soup.find_all("a", href=pattern)
    select = []
    for c in comps:
        for link in links:
            if link.text.strip() == c:
                select.append(link['href'])
                break
    return select

def getState(locale):
    if ',' in locale:
        locale = locale[:locale.find(',')]
    locale = locale.replace('Area','').strip()
    state = locale
    ddg = f"https://api.duckduckgo.com/?q={locale}&format=json&pretty=1&no_html=1&skip_disambig=1"
    try:
        j = requests.get(ddg).json()
        contents = j['Infobox']['content']
        for c in contents:
            if c['label'] == 'State':
                state = c['value']
                break
    except:
        pass
    return state

def comLocate(link):
    page = requests.get(link).text
    soup = BeautifulSoup(page,'html.parser')
    text = soup.text
    sp = text.find('RoC')
    ep = text.find('Registration')
    loc = text[sp+len('RoC'):ep]
    loc = loc.replace('RoC-','')
    loc = loc.strip()
    return loc



def entropy(names, profile):
    expe = profile['experience']
    entrope = 'No entrepreneurial pursuits found.'
    locations = []
    din = None

    if 'location' in profile:
        loca = profile['location']
    else:
        loca = None
    if 'Location' in expe:
        locations = list(set(expe.Location))
    if loca:
        locations = locations + [loca]
    locations = [l for l in locations if str(l).lower()!='nan']
    
    names = [n for n in names if n.strip()]
    
    for query in names:
        name = query.replace(' ','-').strip()
        eurl = f'https://www.zaubacorp.com/directorsearchresults/{name}'
        try:
            tbs = pd.read_html(eurl)
        except:
            tbs = []
            
        if len(tbs) >0:
            df = tbs[0]
            if not expe.empty:
                coms = list(expe.Company)
                coms = [s.lower() for s in coms]
            
                df['dim'] = [match(item, coms) for item in list(df.Company)] 
                dins = list(df.DIN[df.dim])
                if din:
                    din = dins[0]
                    
        if (not din) and (locations) and (tbs):
            df = tbs[0]
            #print(locations)
            locstates = [getState(l) for l in locations]
            #print(locstates)
            locstates = [l for l in locstates if l]
            comurls = comURL(eurl, df)
            comlocs = [comLocate(l) for l in comurls]
            #print(comlocs)
            comstates = [getState(l) for l in comlocs]
            #print(comstates)
            comstates = [l for l in comstates if l]
            comstates = [idx for idx,cs in enumerate(comstates) if cs in locstates]
            df = df.iloc[comstates]
            df = df[df.Name==query.upper()]
            if not df.empty:
                if len(set(df.Name)) > 1:
                    names = list(df.Name)
                    nScores = {n:fuzz.ratio(n.lower(), query.lower()) for n in names}
                    name = max(nScores, key=nScores.get)
                    df = df[df.Name==name]
                    
                din = list(df.DIN)[0]
    
        if din:
            din = str(din)
            if len(din) < 8:
                deff = 8 - len(din)
                din = '0'*deff + din
            print('DIN', din)
            c99page = requests.get(f'https://www.99corporates.com/Director-List/DIN/{din}')
            c99soup = BeautifulSoup(c99page.text, 'html.parser')
            links = c99soup.find_all('a', href=True)
            for link in links:
                if din in link['href']:
                    direct = requests.get('https://www.99corporates.com/'+link['href'])
                    dirSoup = BeautifulSoup(direct.text, 'html.parser')
                    desc = dirSoup.find('span', id="Body_LblDirectorDetail")
                    entrope = desc.text
                    return entrope
                    
    return entrope