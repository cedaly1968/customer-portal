from django.conf.urls import patterns, include, url
# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    # url(r'^$', 'dbportal.views.home', name='home'),
    # url(r'^dbportal/', include('dbportal.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    url(r'^admin/', include(admin.site.urls)),
    ##url(r'^login/$','portal.views.login_page',name="login"),
    url(r'^home/$','portal.views.home_page', name="home"),
    ##url(r'^logout/$','portal.views.logout_view', name="logout"),
    url(r'^revenue/$','portal.views.revenue_page',name="revenue"),
    url(r'^orders/$','portal.views.orders_page',name="orders"),
    url(r'^traffic/$','portal.views.traffic_page',name="traffic"),
    url(r'^home/', include('registration.backends.default.urls')),
    url(r'^setup/$','portal.views.setup_page',name="setup"),
    url(r'', include('banana_py.urls'))
)
