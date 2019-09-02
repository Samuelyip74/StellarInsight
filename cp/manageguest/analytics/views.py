from datetime import datetime, timedelta
from django.db.models import Count
from django.shortcuts import render
from guest.models import Userbehavior


# Create your views here.
def dashboard(request):
    one_week_ago = datetime.today() - timedelta(days=3)
    uni_url = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('url').distinct().count()
    uni_visitors = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('username').distinct().count()
    uni_devices = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('macaddress').distinct().count()
    uni_dstport = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('dstport').distinct().count()
    top_10_users = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('username').annotate(total=Count('username')).order_by('-total')[:10]
    top_10_urls = Userbehavior.objects.filter(datetime__gte=one_week_ago).values('url').annotate(total=Count('url')).order_by('-total')[:11]
    context = {
        'unique_urls' : uni_url,
        'unique_visitors' : uni_visitors,
        'unique_devices' : uni_devices,
        'unique_dstports' : uni_dstport,
        'top10users' : top_10_users,
        'top10urls' : top_10_urls,
    }
    return render(request, "analytics/dashboard.html", context)


def urldetail(request,username):
    one_week_ago = datetime.today() - timedelta(days=3)
    user = username
    urllist = Userbehavior.objects.filter(datetime__gte=one_week_ago,username=user).values('url').distinct()
    context = {
        'user' : username,
        'urllist' : urllist,
    }
    return render(request,"analytics/userdetails.html",context)
