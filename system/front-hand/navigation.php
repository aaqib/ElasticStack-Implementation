<?php 
$acc_privs = split(',', $_SESSION['access_priv']); $chld_privs = split(',', $_SESSION['child_priv']);
 if(isChecked('all', $acc_privs)){ require_once(FRONT.'navigation_admin.php'); }else{?>
<div id="navbox">
<div class="navcont">
<div class="navleft" id="nav">
<ul class="nav-box">

<?php  if(isChecked('home', $acc_privs)){?>
<li class="nav-lifirst"><a class="nav1" href="<?=$path;?>home.php">Home</a></li>

<?php  } if(isChecked('addons', $acc_privs)){?>

<li class="nav-li"><a class="nav2" href="#">Add-ons</a>
  <ul>
<?php  if(isChecked('currency', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Currency</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/currency/index.php">List all Currencies</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/conversions/index.php">List all Conversion Rates</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>addons/currency/add_curency.php">Add New Currency</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>addons/currency/country_curr.php">Edit Country Currency</a></li>


<?php  } if(isChecked('forums', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Forum</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/forum/forum_all.php">List all Forums</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>addons/forum/forum_add.php">Add New Forum</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/forum/frm_desc_all.php">Forum Description</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>addons/forum/frm_rule_all.php">Forum Rules</a></li>
<?php  }if(isChecked('admins', $chld_privs)){?>

<li><a class="navdrp2tit1" href="javascript:;">Site Administrators</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/site_admin/index.php">List all Administrators</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>addons/site_admin/add_admin.php">Add new Administrator</a></li>
<?php  } if(isChecked('language', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Multi Language</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/language/lang_all.php">List all Languages</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/language/lang_add.php">Add new Language</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/language/lang_translt.php">Translation Engine</a></li>
<?php  } if(isChecked('reseller', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Reseller Panel</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_cntall.php">List all Resellers</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_cntadd.php">Add New Reseller</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_custpack.php">Customized Packages</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_preppack.php">Preplan Packages</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_credit.php">Reseller Funds</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_inviall.php">Reseller all Invoices</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_invipaid.php">Reseller Paid Invoices</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>addons/reseller/res_inviunpid.php">Reseller Unpaid Invoices</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>addons/reseller/res_invicancel.php">Reseller Cancel Invoices</a></li>
<?php  }?>
</ul>
</li>
<?php  } if(isChecked('invoices', $acc_privs)){?>
<li class="nav-li"><a class="nav3" href="#">Accounts</a>
<ul>
<li><a href="<?=$path;?>modules/account/invi_all.php">List all Invoices</a></li>
<li><a href="<?=$path;?>modules/account/invi_cancel.php">List Cancelled Invoices</a></li>
<li><a href="<?=$path;?>modules/account/invi_paid.php">List Paid Invoices</a></li>
<li><a class="navdrpbtm1" href="<?=$path;?>modules/account/invi_unpaid.php">List Unpaid Invoices</a></li>
</ul>
</li>
<?php  } if(isChecked('cms', $acc_privs)){?>

<li class="nav-li"><a class="nav4" href="#">CMS</a>
<ul>
<?php  if(isChecked('faqs', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">FAQ</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/faq_add.php">Add new FAQ</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/faq_cat_add.php">Add new Category</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/faq_all.php">List all FAQ's</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/faq_cat.php">List all Categories</a></li>
<?php  } if(isChecked('front_end', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Front-end</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/about_all.php">About us</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/anounce_all.php">Announcement</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/home_all.php">Home page</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/metatag.php">Meta Tags</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/news_all.php">News &amp; events</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/privacy_all.php">Privacy Policy</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/testim_all.php">Testimonials</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/terms_all.php">Terms and Conditions</a></li>
<?php  } if(isChecked('tutorials', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Tutorial</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/tut_add.php">Add new Tutorial</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/tut_all.php">List all Tutorials</a></li>
<!--<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/tut_sec_add.php">Add new Section</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/tut_sec_all.php">List all Sections</a></li>-->
<?php  } ?>
<li><a class="navdrp2tit2" href="javascript:;">Manage Polls</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/poll.php">List all Polls</a></li>
<?php  if(isChecked('servers', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Network Servers</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/server_all.php">List all Servers</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/cms/server_add.php">Add new server</a></li>
<?php  } if(isChecked('pcodes', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Site Promote</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/cms/promo_add.php">Add Promotion Code</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>modules/cms/promo_all.php">List all Code</a></li>
<?php  }?>
</ul>
</li>
<?php  } if(isChecked('customers', $acc_privs)){?>

<li class="nav-li"><a class="nav5" href="#">Customers</a>
<ul>
<?php  if(isChecked('clients', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Manage Clients</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/client_all.php">List all Clients</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/client_add.php">Add new Client</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/client_mass.php">Mass E-mail Clients</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/client_credit.php">Manage Credits</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/client_canreq.php">Cancellation Requests</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/customer/client_vpnpas.php">VPN Password Reset</a></li>
<?php  } if(isChecked('affiliate', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Manage Affiliates</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_plan.php">Affiliate Plan</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_comision.php">Adjust Commissions</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_comhist.php">Commission History</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_paymmet.php">Payment Methods</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_payappr.php">Approve Payout's</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/customer/affil_payrejt.php">Rejects Payout's</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>modules/customer/affil_payunap.php">Unapproved Payout's</a></li>
<?php  }?>
</ul>
</li>
<?php  } if(isChecked('orders', $acc_privs)){?>

<li class="nav-li"><a class="nav6" href="#">Orders</a>
<ul>
<li><a href="<?=$path;?>modules/order/order_all.php">List all Order</a></li>
<li><a href="<?=$path;?>modules/order/order_active.php">List Active Order</a></li>
<li><a href="<?=$path;?>modules/order/order_cancel.php">List Cancelled Order</a></li>
<li><a href="<?=$path;?>modules/order/order_expire.php">List Expired Order</a></li>
<li><a href="<?=$path;?>modules/order/order_fraud.php">List Fraud Order</a></li>
<li><a class="navdrpbtm1" href="<?=$path;?>modules/order/order_pend.php">List Pending Order</a></li>
</ul>
</li>
<?php  } if(isChecked('support', $acc_privs)){?>

<li class="nav-li"><a class="nav7" href="#">Support</a>
<ul>
<?php  if(isChecked('tickets', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Manage Tickets</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_all.php">List all Tickets</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_answer.php">List Answered Tickets</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_reply.php">List Client Replies</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_close.php">List Closed Tickets</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_inprog.php">List In-progress Tickets</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/tick_onhold.php">List On-hold Tickets</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/support/tick_open.php">List Open Tickets</a></li>
<?php  } if(isChecked('tick_settings', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Manage Settings</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/dep_add.php">Add new Department</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/dep_all.php">List all Departments</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/support/cat_add.php">Add new Category</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>modules/support/cat_all.php">List all Categories</a></li>
<?php  }?>
</ul>
</li>
<?php  } if(isChecked('setup', $acc_privs)){?>

<li class="nav-li"><a class="nav8" href="#">Setup</a>
<ul>
<?php  if(isChecked('products', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Manage Products</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/product/cat_all.php">List all Category</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/product/pro_all.php">List all Products</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/product/server_all.php">List all Servers</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/product/pro_add.php">Add new Product</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/product/server_add.php">Add new Server</a></li>
<?php  } if(isChecked('site_config', $chld_privs)){?>

<li><a class="navdrp2tit1" href="javascript:;">Site Configuration</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/conf_credit.php">Adjust Credit Limits</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/conf_band.php">Banned E-mail / Domains</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/conf_notmail.php">Notification E-mails</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/conf_sysconf.php">System Configuration</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/conf_taxapply.php">Tax Apply Setting</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/setup/conf_taxreprt.php">Tax Report</a></li>
<?php  } if(isChecked('payment_modules', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Payment Methods</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/authorize.php">Authorize. Net</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/2checkout.php">2 Checkout</a></li>
<!--<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/google_checkout.php">Goggle Checkout</a></li>-->
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/money_bookers.php">Money Bookers</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/setup/paypal.php">Pay pal</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>modules/setup/liberty_reserve.php">Liberty Reserve</a></li>
<!--<li><a class="navdrpbtm2" href="<?=$path;?>modules/setup/ukash.php">Ukash</a></li>-->
<?php  }?>
</ul>
</li>
<?php  } if(isChecked('util', $acc_privs)){?>

<li class="nav-lilast"><a class="nav9" href="#">Utilities</a>
<ul>
<?php  if(isChecked('bandwidth', $chld_privs)){?>
<li><a class="navdrp2tit1" href="javascript:;">Bandwidth Usage</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/bandwidth/index.php">Active Sessions</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/bandwidth/peak_hour.php">Peak Hours Report</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/bandwidth/system_band.php">Total System bandwidth</a></li>
<li><a class="navdrp2-2" href="<?=$path;?>modules/bandwidth/pie_chart.php">System bandwidth Usage</a></li>
<?php  } if(isChecked('web_act', $chld_privs)){?>

<li><a class="navdrp2tit2" href="javascript:;">Website Activity</a></li>
<li><a class="navdrp2-1" href="<?=$path;?>modules/utilities/web_admin.php">Admin Activities</a></li>
<li><a class="navdrpbtm2" href="<?=$path;?>modules/utilities/web_system.php">System Activities</a></li>
<?php  }?>
</ul>
</li>
<?php  }?>
</ul></div>
<div class="navright">
<div class="srch-fldbox">
<input class="srch-fld" type="text" name="srchfield" id="srchfield" value="Search Here.." />
<?php $limit = 5;?>
<input class="srch-btn" type="image" name="imageField" src="<?=IMG;?>srchfld_btn.jpg" onclick="javascript:document.getElementById('checked').value = '';getData('<?=INC.'search.php';?>?limit=<?=$limit;?>&list=', document.getElementById('srch_list').value+'&parm='+document.getElementById('srchfield').value+'&sort=0&checked=&path=<?=INC?>', 'searchbox'); showDiv('searchbox');" />
</div>
<select class="srch-list" name="srch_list" id="srch_list" >
<option value="invoices">Invoices</option>
<option value="customers">Customers</option>
<option value="services">services</option>
<option value="tickets">Tickets</option>
</select>
<input type="hidden" id="checked" value="" />
<input type="hidden" id="checked_inner" value="" /><br clear="all" />
</div></div></div>
<?php  }?>