from django.db.models import Count
from django.shortcuts import render
from guest.models import Userbehavior


# Create your views here.
def dashboard(request):
    uni_url = Userbehavior.objects.values('url').distinct().count()
    uni_visitors = Userbehavior.objects.values('username').distinct().count()
    uni_devices = Userbehavior.objects.values('macaddress').distinct().count()
    uni_dstport = Userbehavior.objects.values('dstport').distinct().count()
    top_10_users = Userbehavior.objects.all().values('username').annotate(total=Count('username')).order_by('-total')[:10]
    top_10_urls = Userbehavior.objects.all().values('url').annotate(total=Count('url')).order_by('-total')[:11]
    context = {
        'unique_urls' : uni_url,
        'unique_visitors' : uni_visitors,
        'unique_devices' : uni_devices,
        'unique_dstports' : uni_dstport,
        'top10users' : top_10_users,
        'top10urls' : top_10_urls,
    }
    return render(request, "analytics/dashboard.html", context)
