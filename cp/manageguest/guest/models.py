# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from django.db import models


class AuthGroup(models.Model):
    name = models.CharField(unique=True, max_length=150)

    class Meta:
        managed = False
        db_table = 'auth_group'


class AuthGroupPermissions(models.Model):
    group = models.ForeignKey(AuthGroup, models.DO_NOTHING)
    permission = models.ForeignKey('AuthPermission', models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_group_permissions'
        unique_together = (('group', 'permission'),)


class AuthPermission(models.Model):
    name = models.CharField(max_length=255)
    content_type = models.ForeignKey('DjangoContentType', models.DO_NOTHING)
    codename = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'auth_permission'
        unique_together = (('content_type', 'codename'),)


class AuthUser(models.Model):
    password = models.CharField(max_length=128)
    last_login = models.DateTimeField(blank=True, null=True)
    is_superuser = models.IntegerField()
    username = models.CharField(unique=True, max_length=150)
    first_name = models.CharField(max_length=30)
    last_name = models.CharField(max_length=150)
    email = models.CharField(max_length=254)
    is_staff = models.IntegerField()
    is_active = models.IntegerField()
    date_joined = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'auth_user'


class AuthUserGroups(models.Model):
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)
    group = models.ForeignKey(AuthGroup, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_user_groups'
        unique_together = (('user', 'group'),)


class AuthUserUserPermissions(models.Model):
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)
    permission = models.ForeignKey(AuthPermission, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'auth_user_user_permissions'
        unique_together = (('user', 'permission'),)


class BatchHistory(models.Model):
    batch_name = models.CharField(max_length=64, blank=True, null=True)
    batch_description = models.CharField(max_length=256, blank=True, null=True)
    hotspot_id = models.IntegerField(blank=True, null=True)
    batch_status = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'batch_history'


class BillingHistory(models.Model):
    username = models.CharField(max_length=128, blank=True, null=True)
    planid = models.IntegerField(db_column='planId', blank=True, null=True)  # Field name made lowercase.
    billamount = models.CharField(db_column='billAmount', max_length=200, blank=True, null=True)  # Field name made lowercase.
    billaction = models.CharField(db_column='billAction', max_length=128)  # Field name made lowercase.
    billperformer = models.CharField(db_column='billPerformer', max_length=200, blank=True, null=True)  # Field name made lowercase.
    billreason = models.CharField(db_column='billReason', max_length=200, blank=True, null=True)  # Field name made lowercase.
    paymentmethod = models.CharField(max_length=200, blank=True, null=True)
    cash = models.CharField(max_length=200, blank=True, null=True)
    creditcardname = models.CharField(max_length=200, blank=True, null=True)
    creditcardnumber = models.CharField(max_length=200, blank=True, null=True)
    creditcardverification = models.CharField(max_length=200, blank=True, null=True)
    creditcardtype = models.CharField(max_length=200, blank=True, null=True)
    creditcardexp = models.CharField(max_length=200, blank=True, null=True)
    coupon = models.CharField(max_length=200, blank=True, null=True)
    discount = models.CharField(max_length=200, blank=True, null=True)
    notes = models.CharField(max_length=200, blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'billing_history'


class BillingMerchant(models.Model):
    username = models.CharField(max_length=128)
    password = models.CharField(max_length=128)
    mac = models.CharField(max_length=200)
    pin = models.CharField(max_length=200)
    txnid = models.CharField(db_column='txnId', max_length=200)  # Field name made lowercase.
    planname = models.CharField(db_column='planName', max_length=128)  # Field name made lowercase.
    planid = models.IntegerField(db_column='planId')  # Field name made lowercase.
    quantity = models.CharField(max_length=200)
    business_email = models.CharField(max_length=200)
    business_id = models.CharField(max_length=200)
    txn_type = models.CharField(max_length=200)
    txn_id = models.CharField(max_length=200)
    payment_type = models.CharField(max_length=200)
    payment_tax = models.CharField(max_length=200)
    payment_cost = models.CharField(max_length=200)
    payment_fee = models.CharField(max_length=200)
    payment_total = models.CharField(max_length=200)
    payment_currency = models.CharField(max_length=200)
    first_name = models.CharField(max_length=200)
    last_name = models.CharField(max_length=200)
    payer_email = models.CharField(max_length=200)
    payer_address_name = models.CharField(max_length=200)
    payer_address_street = models.CharField(max_length=200)
    payer_address_country = models.CharField(max_length=200)
    payer_address_country_code = models.CharField(max_length=200)
    payer_address_city = models.CharField(max_length=200)
    payer_address_state = models.CharField(max_length=200)
    payer_address_zip = models.CharField(max_length=200)
    payment_date = models.DateTimeField()
    payment_status = models.CharField(max_length=200)
    pending_reason = models.CharField(max_length=200)
    reason_code = models.CharField(max_length=200)
    receipt_id = models.CharField(db_column='receipt_ID', max_length=200)  # Field name made lowercase.
    payment_address_status = models.CharField(max_length=200)
    vendor_type = models.CharField(max_length=200)
    payer_status = models.CharField(max_length=200)

    class Meta:
        managed = False
        db_table = 'billing_merchant'


class BillingPaypal(models.Model):
    username = models.CharField(max_length=128, blank=True, null=True)
    password = models.CharField(max_length=128, blank=True, null=True)
    mac = models.CharField(max_length=200, blank=True, null=True)
    pin = models.CharField(max_length=200, blank=True, null=True)
    txnid = models.CharField(db_column='txnId', max_length=200, blank=True, null=True)  # Field name made lowercase.
    planname = models.CharField(db_column='planName', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planid = models.CharField(db_column='planId', max_length=200, blank=True, null=True)  # Field name made lowercase.
    quantity = models.CharField(max_length=200, blank=True, null=True)
    receiver_email = models.CharField(max_length=200, blank=True, null=True)
    business = models.CharField(max_length=200, blank=True, null=True)
    tax = models.CharField(max_length=200, blank=True, null=True)
    mc_gross = models.CharField(max_length=200, blank=True, null=True)
    mc_fee = models.CharField(max_length=200, blank=True, null=True)
    mc_currency = models.CharField(max_length=200, blank=True, null=True)
    first_name = models.CharField(max_length=200, blank=True, null=True)
    last_name = models.CharField(max_length=200, blank=True, null=True)
    payer_email = models.CharField(max_length=200, blank=True, null=True)
    address_name = models.CharField(max_length=200, blank=True, null=True)
    address_street = models.CharField(max_length=200, blank=True, null=True)
    address_country = models.CharField(max_length=200, blank=True, null=True)
    address_country_code = models.CharField(max_length=200, blank=True, null=True)
    address_city = models.CharField(max_length=200, blank=True, null=True)
    address_state = models.CharField(max_length=200, blank=True, null=True)
    address_zip = models.CharField(max_length=200, blank=True, null=True)
    payment_date = models.DateTimeField(blank=True, null=True)
    payment_status = models.CharField(max_length=200, blank=True, null=True)
    payment_address_status = models.CharField(max_length=200, blank=True, null=True)
    payer_status = models.CharField(max_length=200, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'billing_paypal'


class BillingPlans(models.Model):
    planname = models.CharField(db_column='planName', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planid = models.CharField(db_column='planId', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantype = models.CharField(db_column='planType', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantimebank = models.CharField(db_column='planTimeBank', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantimetype = models.CharField(db_column='planTimeType', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantimerefillcost = models.CharField(db_column='planTimeRefillCost', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planbandwidthup = models.CharField(db_column='planBandwidthUp', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planbandwidthdown = models.CharField(db_column='planBandwidthDown', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantraffictotal = models.CharField(db_column='planTrafficTotal', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantrafficup = models.CharField(db_column='planTrafficUp', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantrafficdown = models.CharField(db_column='planTrafficDown', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantrafficrefillcost = models.CharField(db_column='planTrafficRefillCost', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planrecurring = models.CharField(db_column='planRecurring', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planrecurringperiod = models.CharField(db_column='planRecurringPeriod', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planrecurringbillingschedule = models.CharField(db_column='planRecurringBillingSchedule', max_length=128)  # Field name made lowercase.
    plancost = models.CharField(db_column='planCost', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plansetupcost = models.CharField(db_column='planSetupCost', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plantax = models.CharField(db_column='planTax', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plancurrency = models.CharField(db_column='planCurrency', max_length=128, blank=True, null=True)  # Field name made lowercase.
    plangroup = models.CharField(db_column='planGroup', max_length=128, blank=True, null=True)  # Field name made lowercase.
    planactive = models.CharField(db_column='planActive', max_length=32)  # Field name made lowercase.
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'billing_plans'


class BillingPlansProfiles(models.Model):
    plan_name = models.CharField(max_length=128)
    profile_name = models.CharField(max_length=256, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'billing_plans_profiles'


class BillingRates(models.Model):
    ratename = models.CharField(db_column='rateName', max_length=128)  # Field name made lowercase.
    ratetype = models.CharField(db_column='rateType', max_length=128)  # Field name made lowercase.
    ratecost = models.IntegerField(db_column='rateCost')  # Field name made lowercase.
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'billing_rates'


class Dictionary(models.Model):
    type = models.CharField(db_column='Type', max_length=30, blank=True, null=True)  # Field name made lowercase.
    attribute = models.CharField(db_column='Attribute', max_length=64, blank=True, null=True)  # Field name made lowercase.
    value = models.CharField(db_column='Value', max_length=64, blank=True, null=True)  # Field name made lowercase.
    format = models.CharField(db_column='Format', max_length=20, blank=True, null=True)  # Field name made lowercase.
    vendor = models.CharField(db_column='Vendor', max_length=32, blank=True, null=True)  # Field name made lowercase.
    recommendedop = models.CharField(db_column='RecommendedOP', max_length=32, blank=True, null=True)  # Field name made lowercase.
    recommendedtable = models.CharField(db_column='RecommendedTable', max_length=32, blank=True, null=True)  # Field name made lowercase.
    recommendedhelper = models.CharField(db_column='RecommendedHelper', max_length=32, blank=True, null=True)  # Field name made lowercase.
    recommendedtooltip = models.CharField(db_column='RecommendedTooltip', max_length=512, blank=True, null=True)  # Field name made lowercase.

    class Meta:
        managed = False
        db_table = 'dictionary'


class DjangoAdminLog(models.Model):
    action_time = models.DateTimeField()
    object_id = models.TextField(blank=True, null=True)
    object_repr = models.CharField(max_length=200)
    action_flag = models.PositiveSmallIntegerField()
    change_message = models.TextField()
    content_type = models.ForeignKey('DjangoContentType', models.DO_NOTHING, blank=True, null=True)
    user = models.ForeignKey(AuthUser, models.DO_NOTHING)

    class Meta:
        managed = False
        db_table = 'django_admin_log'


class DjangoContentType(models.Model):
    app_label = models.CharField(max_length=100)
    model = models.CharField(max_length=100)

    class Meta:
        managed = False
        db_table = 'django_content_type'
        unique_together = (('app_label', 'model'),)


class DjangoMigrations(models.Model):
    app = models.CharField(max_length=255)
    name = models.CharField(max_length=255)
    applied = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_migrations'


class DjangoSession(models.Model):
    session_key = models.CharField(primary_key=True, max_length=40)
    session_data = models.TextField()
    expire_date = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'django_session'


class Hotspots(models.Model):
    id = models.BigAutoField(primary_key=True)
    name = models.CharField(max_length=200, blank=True, null=True)
    mac = models.CharField(max_length=200, blank=True, null=True)
    geocode = models.CharField(max_length=200, blank=True, null=True)
    owner = models.CharField(max_length=200, blank=True, null=True)
    email_owner = models.CharField(max_length=200, blank=True, null=True)
    manager = models.CharField(max_length=200, blank=True, null=True)
    email_manager = models.CharField(max_length=200, blank=True, null=True)
    address = models.CharField(max_length=200, blank=True, null=True)
    company = models.CharField(max_length=200, blank=True, null=True)
    phone1 = models.CharField(max_length=200, blank=True, null=True)
    phone2 = models.CharField(max_length=200, blank=True, null=True)
    type = models.CharField(max_length=200, blank=True, null=True)
    companywebsite = models.CharField(max_length=200, blank=True, null=True)
    companyemail = models.CharField(max_length=200, blank=True, null=True)
    companycontact = models.CharField(max_length=200, blank=True, null=True)
    companyphone = models.CharField(max_length=200, blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'hotspots'


class Invoice(models.Model):
    user_id = models.IntegerField(blank=True, null=True)
    batch_id = models.IntegerField(blank=True, null=True)
    date = models.DateTimeField()
    status_id = models.IntegerField()
    type_id = models.IntegerField()
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'invoice'


class InvoiceItems(models.Model):
    invoice_id = models.IntegerField()
    plan_id = models.IntegerField(blank=True, null=True)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    tax_amount = models.DecimalField(max_digits=10, decimal_places=2)
    total = models.DecimalField(max_digits=10, decimal_places=2)
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'invoice_items'


class InvoiceStatus(models.Model):
    value = models.CharField(max_length=32)
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'invoice_status'


class InvoiceType(models.Model):
    value = models.CharField(max_length=32)
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'invoice_type'


class Nas(models.Model):
    nasname = models.CharField(max_length=128)
    shortname = models.CharField(max_length=32, blank=True, null=True)
    type = models.CharField(max_length=30, blank=True, null=True)
    ports = models.IntegerField(blank=True, null=True)
    secret = models.CharField(max_length=60)
    server = models.CharField(max_length=64, blank=True, null=True)
    community = models.CharField(max_length=50, blank=True, null=True)
    description = models.CharField(max_length=200, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'nas'


class Node(models.Model):
    time = models.DateTimeField()
    netid = models.IntegerField()
    name = models.CharField(max_length=100)
    description = models.CharField(max_length=100)
    latitude = models.CharField(max_length=20)
    longitude = models.CharField(max_length=20)
    owner_name = models.CharField(max_length=50)
    owner_email = models.CharField(max_length=50)
    owner_phone = models.CharField(max_length=25)
    owner_address = models.CharField(max_length=100)
    approval_status = models.CharField(max_length=1)
    ip = models.CharField(max_length=20)
    mac = models.CharField(unique=True, max_length=20)
    uptime = models.CharField(max_length=100)
    robin = models.CharField(max_length=20)
    batman = models.CharField(max_length=20)
    memfree = models.CharField(max_length=20)
    nbs = models.TextField()
    gateway = models.CharField(max_length=20)
    gw_qual = models.CharField(db_column='gw-qual', max_length=20)  # Field renamed to remove unsuitable characters.
    routes = models.TextField()
    users = models.CharField(max_length=3)
    kbdown = models.CharField(max_length=20)
    kbup = models.CharField(max_length=20)
    hops = models.CharField(max_length=3)
    rank = models.CharField(max_length=3)
    ssid = models.CharField(max_length=20)
    pssid = models.CharField(max_length=20)
    gateway_bit = models.IntegerField()
    memlow = models.CharField(max_length=20)
    usershi = models.CharField(max_length=3)
    cpu = models.FloatField()
    wan_iface = models.CharField(max_length=128, blank=True, null=True)
    wan_ip = models.CharField(max_length=128, blank=True, null=True)
    wan_mac = models.CharField(max_length=128, blank=True, null=True)
    wan_gateway = models.CharField(max_length=128, blank=True, null=True)
    wifi_iface = models.CharField(max_length=128, blank=True, null=True)
    wifi_ip = models.CharField(max_length=128, blank=True, null=True)
    wifi_mac = models.CharField(max_length=128, blank=True, null=True)
    wifi_ssid = models.CharField(max_length=128, blank=True, null=True)
    wifi_key = models.CharField(max_length=128, blank=True, null=True)
    wifi_channel = models.CharField(max_length=128, blank=True, null=True)
    lan_iface = models.CharField(max_length=128, blank=True, null=True)
    lan_mac = models.CharField(max_length=128, blank=True, null=True)
    lan_ip = models.CharField(max_length=128, blank=True, null=True)
    wan_bup = models.CharField(max_length=128, blank=True, null=True)
    wan_bdown = models.CharField(max_length=128, blank=True, null=True)
    firmware = models.CharField(max_length=128, blank=True, null=True)
    firmware_revision = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'node'


class Operators(models.Model):
    username = models.CharField(max_length=32)
    password = models.CharField(max_length=32)
    firstname = models.CharField(max_length=32)
    lastname = models.CharField(max_length=32)
    title = models.CharField(max_length=32)
    department = models.CharField(max_length=32)
    company = models.CharField(max_length=32)
    phone1 = models.CharField(max_length=32)
    phone2 = models.CharField(max_length=32)
    email1 = models.CharField(max_length=32)
    email2 = models.CharField(max_length=32)
    messenger1 = models.CharField(max_length=32)
    messenger2 = models.CharField(max_length=32)
    notes = models.CharField(max_length=128)
    lastlogin = models.DateTimeField(blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'operators'


class OperatorsAcl(models.Model):
    operator_id = models.IntegerField()
    file = models.CharField(max_length=128)
    access = models.IntegerField()

    class Meta:
        managed = False
        db_table = 'operators_acl'


class OperatorsAclFiles(models.Model):
    file = models.CharField(max_length=128)
    category = models.CharField(max_length=128)
    section = models.CharField(max_length=128)

    class Meta:
        managed = False
        db_table = 'operators_acl_files'


class Payment(models.Model):
    invoice_id = models.IntegerField()
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    date = models.DateTimeField()
    type_id = models.IntegerField()
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'payment'


class PaymentType(models.Model):
    value = models.CharField(max_length=32)
    notes = models.CharField(max_length=128)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'payment_type'


class Proxys(models.Model):
    id = models.BigAutoField(primary_key=True)
    proxyname = models.CharField(max_length=128, blank=True, null=True)
    retry_delay = models.IntegerField(blank=True, null=True)
    retry_count = models.IntegerField(blank=True, null=True)
    dead_time = models.IntegerField(blank=True, null=True)
    default_fallback = models.IntegerField(blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'proxys'


class Radacct(models.Model):
    radacctid = models.BigAutoField(primary_key=True)
    acctsessionid = models.CharField(max_length=64)
    acctuniqueid = models.CharField(unique=True, max_length=32)
    username = models.CharField(max_length=64)
    realm = models.CharField(max_length=64, blank=True, null=True)
    nasipaddress = models.CharField(max_length=15)
    nasportid = models.CharField(max_length=15, blank=True, null=True)
    nasporttype = models.CharField(max_length=32, blank=True, null=True)
    acctstarttime = models.DateTimeField(blank=True, null=True)
    acctupdatetime = models.DateTimeField(blank=True, null=True)
    acctstoptime = models.DateTimeField(blank=True, null=True)
    acctinterval = models.IntegerField(blank=True, null=True)
    acctsessiontime = models.PositiveIntegerField(blank=True, null=True)
    acctauthentic = models.CharField(max_length=32, blank=True, null=True)
    connectinfo_start = models.CharField(max_length=50, blank=True, null=True)
    connectinfo_stop = models.CharField(max_length=50, blank=True, null=True)
    acctinputoctets = models.BigIntegerField(blank=True, null=True)
    acctoutputoctets = models.BigIntegerField(blank=True, null=True)
    calledstationid = models.CharField(max_length=50)
    callingstationid = models.CharField(max_length=50)
    acctterminatecause = models.CharField(max_length=32)
    servicetype = models.CharField(max_length=32, blank=True, null=True)
    framedprotocol = models.CharField(max_length=32, blank=True, null=True)
    framedipaddress = models.CharField(max_length=15)

    class Meta:
        managed = False
        db_table = 'radacct'


class Radcheck(models.Model):
    id = models.BigAutoField(primary_key=True)
    username = models.CharField(max_length=64)
    attribute = models.CharField(max_length=64)
    op = models.CharField(max_length=2)
    value = models.CharField(max_length=253)

    class Meta:
        managed = False
        db_table = 'radcheck'


class Radgroupcheck(models.Model):
    groupname = models.CharField(max_length=64)
    attribute = models.CharField(max_length=64)
    op = models.CharField(max_length=2)
    value = models.CharField(max_length=253)

    class Meta:
        managed = False
        db_table = 'radgroupcheck'


class Radgroupreply(models.Model):
    groupname = models.CharField(max_length=64)
    attribute = models.CharField(max_length=64)
    op = models.CharField(max_length=2)
    value = models.CharField(max_length=253)

    class Meta:
        managed = False
        db_table = 'radgroupreply'


class Radpostauth(models.Model):
    username = models.CharField(max_length=64)
    pass_field = models.CharField(db_column='pass', max_length=64)  # Field renamed because it was a Python reserved word.
    reply = models.CharField(max_length=32)
    authdate = models.DateTimeField()

    class Meta:
        managed = False
        db_table = 'radpostauth'


class Radreply(models.Model):
    username = models.CharField(max_length=64)
    attribute = models.CharField(max_length=64)
    op = models.CharField(max_length=2)
    value = models.CharField(max_length=253)

    class Meta:
        managed = False
        db_table = 'radreply'


class Radusergroup(models.Model):
    username = models.CharField(max_length=64)
    groupname = models.CharField(max_length=64)
    priority = models.IntegerField()

    class Meta:
        managed = False
        db_table = 'radusergroup'


class Realms(models.Model):
    id = models.BigAutoField(primary_key=True)
    realmname = models.CharField(max_length=128, blank=True, null=True)
    type = models.CharField(max_length=32, blank=True, null=True)
    authhost = models.CharField(max_length=256, blank=True, null=True)
    accthost = models.CharField(max_length=256, blank=True, null=True)
    secret = models.CharField(max_length=128, blank=True, null=True)
    ldflag = models.CharField(max_length=64, blank=True, null=True)
    nostrip = models.IntegerField(blank=True, null=True)
    hints = models.IntegerField(blank=True, null=True)
    notrealm = models.IntegerField(blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'realms'


class Userbehavior(models.Model):
    datetime = models.DateTimeField()
    macaddress = models.CharField(max_length=32)
    username = models.CharField(max_length=32)
    url = models.CharField(max_length=32)
    protocol = models.CharField(max_length=32)
    ipaddress = models.CharField(max_length=32)
    srcport = models.CharField(max_length=32)
    dstip = models.CharField(max_length=32)
    dstport = models.CharField(max_length=32)

    class Meta:
        managed = False
        db_table = 'userbehavior'


class Userbillinfo(models.Model):
    username = models.CharField(max_length=128, blank=True, null=True)
    planname = models.CharField(db_column='planName', max_length=128, blank=True, null=True)  # Field name made lowercase.
    hotspot_id = models.IntegerField(blank=True, null=True)
    hotspotlocation = models.CharField(max_length=32, blank=True, null=True)
    contactperson = models.CharField(max_length=200, blank=True, null=True)
    company = models.CharField(max_length=200, blank=True, null=True)
    email = models.CharField(max_length=200, blank=True, null=True)
    phone = models.CharField(max_length=200, blank=True, null=True)
    address = models.CharField(max_length=200, blank=True, null=True)
    city = models.CharField(max_length=200, blank=True, null=True)
    state = models.CharField(max_length=200, blank=True, null=True)
    country = models.CharField(max_length=100, blank=True, null=True)
    zip = models.CharField(max_length=200, blank=True, null=True)
    paymentmethod = models.CharField(max_length=200, blank=True, null=True)
    cash = models.CharField(max_length=200, blank=True, null=True)
    creditcardname = models.CharField(max_length=200, blank=True, null=True)
    creditcardnumber = models.CharField(max_length=200, blank=True, null=True)
    creditcardverification = models.CharField(max_length=200, blank=True, null=True)
    creditcardtype = models.CharField(max_length=200, blank=True, null=True)
    creditcardexp = models.CharField(max_length=200, blank=True, null=True)
    notes = models.CharField(max_length=200, blank=True, null=True)
    changeuserbillinfo = models.CharField(max_length=128, blank=True, null=True)
    lead = models.CharField(max_length=200, blank=True, null=True)
    coupon = models.CharField(max_length=200, blank=True, null=True)
    ordertaker = models.CharField(max_length=200, blank=True, null=True)
    billstatus = models.CharField(max_length=200, blank=True, null=True)
    lastbill = models.DateField()
    nextbill = models.DateField()
    nextinvoicedue = models.IntegerField(blank=True, null=True)
    billdue = models.IntegerField(blank=True, null=True)
    postalinvoice = models.CharField(max_length=8, blank=True, null=True)
    faxinvoice = models.CharField(max_length=8, blank=True, null=True)
    emailinvoice = models.CharField(max_length=8, blank=True, null=True)
    batch_id = models.IntegerField(blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'userbillinfo'


class Userinfo(models.Model):
    username = models.CharField(max_length=128, blank=True, null=True)
    firstname = models.CharField(max_length=200, blank=True, null=True)
    lastname = models.CharField(max_length=200, blank=True, null=True)
    email = models.CharField(max_length=200, blank=True, null=True)
    department = models.CharField(max_length=200, blank=True, null=True)
    company = models.CharField(max_length=200, blank=True, null=True)
    workphone = models.CharField(max_length=200, blank=True, null=True)
    homephone = models.CharField(max_length=200, blank=True, null=True)
    mobilephone = models.CharField(max_length=200, blank=True, null=True)
    address = models.CharField(max_length=200, blank=True, null=True)
    city = models.CharField(max_length=200, blank=True, null=True)
    state = models.CharField(max_length=200, blank=True, null=True)
    country = models.CharField(max_length=100, blank=True, null=True)
    zip = models.CharField(max_length=200, blank=True, null=True)
    notes = models.CharField(max_length=200, blank=True, null=True)
    changeuserinfo = models.CharField(max_length=128, blank=True, null=True)
    portalloginpassword = models.CharField(max_length=128, blank=True, null=True)
    enableportallogin = models.IntegerField(blank=True, null=True)
    creationdate = models.DateTimeField(blank=True, null=True)
    creationby = models.CharField(max_length=128, blank=True, null=True)
    updatedate = models.DateTimeField(blank=True, null=True)
    updateby = models.CharField(max_length=128, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'userinfo'
