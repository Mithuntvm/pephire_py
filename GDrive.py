# -*- coding: utf-8 -*-
"""
Created on Thu Jun  8 16:13:53 2023

@author: mithun
"""

# -*- coding: utf-8 -*-
"""
pip install --upgrade google-api-python-client
"""
import os,pickle
from google_auth_oauthlib.flow import Flow, InstalledAppFlow
from googleapiclient.discovery import build
from googleapiclient.http import MediaFileUpload, MediaIoBaseDownload
from google.auth.transport.requests import Request
def Create_Service(CLIENT_SECRET_FILE, API_SERVICE_NAME, API_VERSION, *scopes):
    SCOPES = [scope for scope in scopes[0]]
    print(SCOPES)
    cred = None
    pickle_file = f'token_{API_NAME}_{API_VERSION}.pickle'
    # print(pickle_file)

    if os.path.exists(pickle_file):
        with open(pickle_file, 'rb') as token:
            cred = pickle.load(token)

    if not cred or not cred.valid:
        if cred and cred.expired and cred.refresh_token:
            cred.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(CLIENT_SECRET_FILE, SCOPES)
            cred = flow.run_local_server()

        with open(pickle_file, 'wb') as token:
            pickle.dump(cred, token)

    try:
        service = build(API_NAME, API_VERSION, credentials=cred)
        print(API_NAME, 'service created successfully')
        return service
    except Exception as e:
        print('Unable to connect.')
        print(e)
        return None
SCOPES = ['https://www.googleapis.com/auth/drive']
API_NAME = 'drive'
API_VERSION = 'v3'
CLIENT_SECRET_FILE = 'ApplicationAutonomous.json'

from flask import Flask, request, jsonify

app = Flask(__name__)
@app.route('/', methods=['GET', 'POST'])
def getGoogleDriveLink():
    data = request.get_json()
    #Create service object
    service = Create_Service(CLIENT_SECRET_FILE, API_NAME, API_VERSION, SCOPES)
    #Create object in google drive
    Foldername = data['FolderName']
    file_metadata = {'name':Foldername, 'mimeType':'application/vnd.google-apps.folder'}
    r = service.files().create(body=file_metadata).execute()
    Fileid=r['id']
    #Providing write permission to the folder
    res = service.permissions().create(body={"role":"writer", "type":"anyone"}, fileId=r['id']).execute()
    print(res)
    #Getting the shared link
    response_share_link = service.files().get(fileId=Fileid,fields='webViewLink').execute()
    return(response_share_link['webViewLink'])

app.run(port=1234)