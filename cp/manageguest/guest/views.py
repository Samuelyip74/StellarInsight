from django.shortcuts import render
from .models import Userbehavior


# Create your views here.
def dashboard(request):
    uni_url = Userbehavior.objects.values('url').distinct().count()
    uni_visitors = Userbehavior.objects.values('username').distinct().count()
    uni_devices = Userbehavior.objects.values('macaddress').distinct().count()
    context = {
        'unique_url' : uni_url,
        'unique_visitors' : uni_visitors,
        'unique_devices' : uni_devices,
    }
    return render(request, "guest/dashboard.html", context)
