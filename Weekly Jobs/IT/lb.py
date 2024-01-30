import win32com.client as win32
from win32com.client import Dispatch
import os
def SendmailAlert(Subject,Message):
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    # mail.To = 'sanjna@sentientscripts.com;mithun@sentientscripts.com;priya@sentientscripts.com;sameer@sentientscripts.com'
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = Subject
    mail.Body = Message
    mail.Send()

def SendMailAttachItem(Subject,Message):
    outlook = win32.Dispatch('outlook.application')
    mail = outlook.CreateItem(0)
    # mail.To = 'sanjna@sentientscripts.com;mithun@sentientscripts.com;priya@sentientscripts.com;sameer@sentientscripts.com'
    mail.To = 'sanjna@sentientscripts.com'
    mail.Subject = Subject
    mail.Body = Message
    mail.Attachments.Add(os.path.join(os.getcwd(),'NewJobsAdded.xlsx'))
    mail.Attachments.Add(os.path.join(os.getcwd(),'SearchQry.xlsx'))
    mail.Send()