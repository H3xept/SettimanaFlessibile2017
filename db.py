import MySQLdb
db = MySQLdb.connect("127.0.0.1","root","239048OIUIOEFoiufw","settflex")
cursor = db.cursor()
users = open('formatted','r')
arr = []


for line in users:
	components = line.split(" ")
	complete_name = components[:-3]
	surname = complete_name[-1]
	name = " ".join(complete_name[:-1])
	username = components[-3]
	password = (components[-1])[:-1]
	class_ = components[-2]
	arr.append([name,surname,username,class_,password])

subsets = [arr[:1000],arr[1000:]]
for subset in subsets:
	cursor.executemany('''INSERT into users_installer (name,surname,username,class,password) values (%s,%s,%s,%s,%s)''',subset)
	db.commit()

db.close()
