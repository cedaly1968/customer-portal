## File Handler

def handle_uploaded_file(f):
	fl ='static/%s%s%s.txt.' % (LoginForm.username, UploadFileForm.Title, time.strftime('%y%m%d_%H%M%S'))
	with open(fl, 'wb+') as destination:
		for chunk in f.chunks():
			desitnation.write(chunk)