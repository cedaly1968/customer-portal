
# import required classes
import httplib2
import tempfile
import json
from apiclient.discovery import build
from oauth2client.client import flow_from_clientsecrets
from oauth2client.file import Storage
from oauth2client.tools import run

secret = tempfile.NamedTemporaryFile()
CLIENT_SECRETS = {"installed": {
    "client_id": "473652820357-ttvijm1a9v8h5qprt9fadmp2voh2e4v7.apps.googleusercontent.com",
    "client_secret": "FpXdWwErfFdpEiVz222y3J7g",
    "redirect_uris": "http://localhost:8080/",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://accounts.google.com/o/oauth2/token"}}
    

secret.write(json.dumps(CLIENT_SECRETS))
secret.read()
json.dump(CLIENT_SECRETS,secret)
    
# The Flow object to be used if we need to authenticate.
FLOW = flow_from_clientsecrets(secret.name,
    scope='https://www.googleapis.com/auth/analytics.readonly')





def prepare_credentials(TOKEN_FILE_NAME):
  # Retrieve existing credendials
  storage = Storage(TOKEN_FILE_NAME)
  credentials = storage.get()

  # If existing credentials are invalid and Run Auth flow
  # the run method will store any new credentials
  ##if credentials is None or credentials.invalid:
  credentials = run(FLOW, storage) #run Auth Flow and store credentials
  
  return credentials
  
'''  
def initialize_service():
  # 1. Create an http object
  http = httplib2.Http()

  # 2. Authorize the http object
  # In this tutorial we first try to retrieve stored credentials. If
  # none are found then run the Auth Flow. This is handled by the
  # prepare_credentials() function defined earlier in the tutorial
  credentials = prepare_credentials()
  http = credentials.authorize(http)  # authorize the http object
  cred = tokenfile.read()

  # 3. Build the Analytics Service Object with the authorized http object
  return cred
'''  
  