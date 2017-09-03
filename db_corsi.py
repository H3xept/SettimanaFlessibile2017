import MySQLdb

# encoding=latin1 
import sys

reload(sys)
sys.setdefaultencoding('utf8')

db = MySQLdb.connect("127.0.0.1","root","239048OIUIOEFoiufw","settflex" )
cursor = db.cursor()
courses = open('corsi_divided','r')

components = courses.read().split("###")
names = components[0].split('\n')
names.pop(-1)
descs = components[1].split('\n')
descs.pop(0)
refs = components[2].split('\n')
refs.pop(0)
prefs = components[3].split('\n')
prefs.pop(0)
progr = components[4].split('\n')
progr.pop(0)
lun2 = components[5].split('\n')
lun2.pop(0)
lun3 = components[6].split('\n')
lun3.pop(0)
mar2 = components[7].split('\n')
mar2.pop(0)
mar3 = components[8].split('\n')
mar3.pop(0)
mer2 = components[9].split('\n')
mer2.pop(0)
mer3 = components[10].split('\n')
mer3.pop(0)
gio1 = components[11].split('\n')
gio1.pop(0)
gio2 = components[12].split('\n')
gio2.pop(0)
gio3 = components[13].split('\n')
gio3.pop(0)
maxs = components[14].split('\n')
maxs.pop(0)
print(descs[0])
courses_list = []
ref_insert = []
for x in range(len(names)):
	name = names[x]
	desc = descs[x]
	refs_= refs[x]
	for ref_ in refs_.split(", "):
		ref_components = ref_.split(" ")
		ref_name = ref_components[:-2]
		ref_surname = ref_components[-2]
		ref_class = ref_components[-1]
		ref_insert.append([x+1,ref_name,ref_surname,ref_class])
	prefs_ = prefs[x]
	progr_ = progr[x]
	lun2_ = lun2[x]
	lun3_ = lun3[x]
	mar2_ = mar2[x]
	mar3_ = mar3[x]
	mer2_ = mer2[x]
	mer3_ = mer3[x]
	gio1_ = gio1[x]
	gio2_ = gio2[x]
	gio3_ = gio3[x]
	maxs_ = maxs[x]
	course = [name.replace("\\",""),desc.replace("\\",""),refs_,prefs_,progr_,lun2_,lun3_,mar2_,mar3_,mer2_,mer3_,gio1_,gio2_,gio3_,maxs_]
	courses_list.append(course)

cursor.executemany('''INSERT into courses_installer (name,`desc`,ref,pRef,type,f1,f2,f3,f4,f5,f6,f7,f8,f9,maxStudentsPerSession) values (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)''',courses_list)
for ref_combo in ref_insert:
	correct_refs = ref_combo[0]
	select = 'SELECT refin FROM users_installer WHERE name="%s" AND surname="%s" AND class="%s"' % (ref_combo[1][0],ref_combo[2],ref_combo[3])
	cursor.execute(select)
	for refin in cursor:
		if(refin[0] != None):
			correct_refs = str(refin[0])+","+str(correct_refs)
	stat = 'UPDATE users_installer SET refin="%s" WHERE name="%s" AND surname="%s" AND class="%s"' % (correct_refs,ref_combo[1][0],ref_combo[2],ref_combo[3])
	cursor.execute(stat)
db.commit()
db.close()
