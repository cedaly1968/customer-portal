from django.db import models
from django.forms import ModelForm
from django.contrib.auth.models import User
from django.db.models.signals import post_save


# Create your models here.


class dashfacts(models.Model):
    user = models.OneToOneField(User)
    userkey = models.AutoField(primary_key=True)
    bg_store_url = models.URLField()
    bg_api_key = models.CharField(max_length=50)
    bg_user_name = models.CharField(max_length=9 , default='dashfacts')
    ga_token = models.TextField()
    mc_token = models.TextField()
    
    def __str__(self):  
    	return "%s's profile" % self.user  
    def __str__(self):
    	return self.bg_store_url

def create_user_profile(sender, instance, created, **kwargs):
	if created:
		profile, created = dashfacts.objects.get_or_create(user=instance)  

post_save.connect(create_user_profile, sender=User) 
    
    
class dashfactsForm(ModelForm):
	class Meta:
		model = dashfacts
		fields = ['bg_store_url','bg_api_key']


class revenue(models.Model):
	userkey = models.IntegerField()
	date = models.DateField()
	revenue = models.FloatField()
	product = models.TextField()
	
	def __unicode__(self):
		return self.userkey
	def __unicode__(self):
		return self.date
	def __unicode__(self):
		return self.revenue
	def __unicode__(self):
		return self.product
