# Create your views here.
from django.template import RequestContext
from django.shortcuts import render_to_response, redirect
from forms import LoginForm
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
import time
from portal.models import revenue
from django.core import serializers
import pandas as pd


'''
## Login Page View
def login_page(request):
	message = None
	if request.method == "POST":
		form = LoginForm(request.POST)
		if form.is_valid():
			username = request.POST['username']
			password = request.POST['password']
			user = authenticate(username=username, password=password)
			if user is not None:
				if user.is_active:
					login(request, user)
					return redirect('home')
				else:
					message = "Your user is inactive"
			else:
				message = "Invalid username and/or password"
	else:
		form = LoginForm()
	return render_to_response('home/login.html',{'message':message, 'form':form}, context_instance=RequestContext(request))

## Logout Page View
def logout_view(request):
	logout(request)
	return redirect('login')
'''

## Home Page View
@login_required
def home_page(request):
	logged_user = request.user.id
	rev = revenue.objects.filter(userkey=logged_user).values('revenue','product')
	##data = serializers.serialize("json", rev)
	dat = pd.DataFrame(list(rev))
	dat = pd.DataFrame(dat, columns = ['revenue','product'])
	dat = dat['revenue'].groupby(dat['product']).sum()
	dat.columns = ['product','total revenue']
	dat = dict(dat)
	return render_to_response('home.html', {'dat':dat}, context_instance=RequestContext(request))


## Campaign Page View	
@login_required
def revenue_page(request):

	return render_to_response('revenue.html', context_instance=RequestContext(request))


## File Upload Page View	
@login_required	
def traffic_page(request):

	return render_to_response('traffic.html', context_instance=RequestContext(request))

	
## File Download Page View	
@login_required	
def orders_page(request):

	return render_to_response('orders.html', context_instance=RequestContext(request))
	
## Setup Page	
from portal.models import dashfactsForm
from portal.models import dashfacts
from django.core.exceptions  import ObjectDoesNotExist
import tempfile
import GA
from django.conf import settings
from django.views.generic.base import TemplateView
from django.http import HttpResponseRedirect

from banana_py import Bananas_OAuth

@login_required
def setup_page(request):
## Handles BigCommerce Setup
	if request.method =='POST' and request.POST.get('BG'):
		try:
			user = dashfacts.objects.get(user_id = request.user.id)
			bgform = dashfactsForm(request.POST, instance = user)
		except ObjectDoesNotExist:
			bgform = dashfactsForm(request.POST, request.FILES)
		if bgform.is_valid():
			bgprof = bgform.save(commit=False)
			bgprof.user_id = request.user.id
			bgform.save()
			return redirect('setup')
	else:
		try: 
			user = dashfacts.objects.get(user_id = request.user.id)
			bgform = dashfactsForm(instance = user)
		except ObjectDoesNotExist:
			bgform = dashfactsForm(request.FILES)
	## Displays message about BG Authentication
	try :
		dashfacts.objects.get(user_id = request.user.id, bg_api_key__isnull=True)
		bgmessage = {'warning':'Please enter your BigCommerce Credentials!'}
	except:
		bgmessage = {'success':'You\'ve already authenticated BigCommerce! Yippie!'}

## Handles Google Analytics Setup
	if request.method =='POST' and request.POST.get('GA'):
		tokenfile=tempfile.NamedTemporaryFile()
		TOKEN_FILE_NAME = tokenfile.name
		GA.prepare_credentials(TOKEN_FILE_NAME)
		token = tokenfile.read()
		token = str(token)
		gacreds = dashfacts.objects.get(user_id = request.user.id)
		gacreds.ga_token = token
		gacreds.save()			
		return redirect('setup')	
		## Displays message about GA Authentication
	try :
		dashfacts.objects.get(user_id = request.user.id, ga_token__isnull=True)
		gamsg = {'warning':'Please click to integrate Google Analytics!'}
	except:
		gamsg = {'success':'You\'ve already integrated Google Analytics! Yippie!'}

	if request.method =='POST' and request.POST.get('MC'):
		print 'test'
		
		## Displays message about GA Authentication
	try :
		dashfacts.objects.get(user_id = request.user.id, mc_token__isnull=True)
		mcmsg = {'warning':'Please click to integrate MailChimp!'}
	except:
		mcmsg = {'success':'You\'ve already integrated MailChimp! Yippie!'}

	return render_to_response('setup.html',{'bgform':bgform,'bgmessage':bgmessage,'gamsg':gamsg,'mcmsg':mcmsg}, context_instance=RequestContext(request))
	



	
	
