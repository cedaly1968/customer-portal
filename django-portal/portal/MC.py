
import oauth2 as oauth
import simplejson
from django.template.defaultfilters import urlencode

class Bananas_OAuth(object):
    mc_authorize_uri = 'https://login.mailchimp.com/oauth2/authorize'
    mc_access_token_uri = 'https://login.mailchimp.com/oauth2/token'
    mc_metadata_uri = 'https://login.mailchimp.com/oauth2/metadata'

    def __init__(self, *args, **kwargs):
        self.client_id = '880973178381'
        self.client_secret =  '01494220e93258aaa9bf62fbd91f0c93'
        self.redirect_uri = 'http://127.0.0.1:8000/setup'
        self.client = oauth.Client(oauth.Consumer(key=self.client_id,
            secret=self.client_secret))

        if not self.client_id:
            raise ImproperlyConfigured("Missing Client ID settings.")
        if not self.client_secret:
            raise ImproperlyConfigured("Missing Client Secret")
        if not self.redirect_uri:
            raise ImproperlyConfigured("Missing Redirect URI")

    def _params(self, code):
        return u'grant_type=%s&code=%s&redirect_uri=%s&client_id=%s&client_secret=%s' % (
            'authorization_code', code, self.redirect_uri, self.client_id,
            self.client_secret)

    def _magic_header(self, token):
        """
        From Mail Chimps docs. This header is the 'magic' that makes this
        empty GET request work.
        """
        return {'Authorization': 'OAuth %s' % token}

    def authenticate(self, code):
        response = {}
        resp, content = self.client.request(self.mc_access_token_uri,
            'POST', self._params(code))
        response.update(simplejson.loads(content))

        resp, content = self.client.request(self.mc_metadata_uri,
            'GET', headers=self._magic_header(response['access_token']))
        response.update(simplejson.loads(content))

        return response

    def authorize_url(self):
        return u'%s?response_type=code&client_id=%s&redirect_uri=%s' % (
            self.mc_authorize_uri, self.client_id, urlencode(self.redirect_uri))




Bananas_OAuth().authorize_url()

bananas = Bananas_OAuth().authenticate(code)
request.session['mailchimp_details'] = bananas