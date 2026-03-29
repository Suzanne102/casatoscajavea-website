#!/usr/bin/python
#!/my first python file this is from AI
import cgi
import cgitb; cgitb.enable()  # for troubleshooting

print "Content-type: text/html\n\n"
print "<html><head>"
print "<title>Booking Confirmation</title>"
print "</head><body>"

form = cgi.FieldStorage()
first_name = form.getvalue('firstName')
last_name = form.getvalue('lastName')
email = form.getvalue('email')
phone = form.getvalue('phone')
apartment_no = form.getvalue('Apartment No.')
check_in_date = form.getvalue('checkInDate')
check_out_date = form.getvalue('checkOutDate')

print "<h1>Thank You for Your Booking</h1>"
print "<p>Your booking details:</p>"
print "<ul>"
print "<li>Name: %s %s</li>" % (first_name, last_name)
print "<li>Email: %s</li>" % email
print "<li>Phone: %s</li>" % phone
print "<li>Apartment No.: %s</li>" % apartment_no
print "<li>Check-in Date: %s</li>" % check_in_date
print "<li>Check-out Date: %s</li>" % check_out_date
print "</ul>"

print "</body></html>"
