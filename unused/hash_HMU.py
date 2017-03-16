# hash en 12 octets

import random  # on en a besoin our les tests

def separation(c) : 
# prend la chaine de caracteres c en entree et sort la liste des bouts de c de taille 12o, eventuellement completes par des 0
	b = string2bin(c) 
	l = []
	for i in range(len(b)//12) : 
		x = b[12*i:12*(i+1)]
		l = l + [x]
	# dernier element : 
	x = b[12*(len(b)//12):]
	while len(x) < 12 :   # on ajoute des zeros au besoin 
		x =  x + '0'
	l = l + [x]
	return l
	
	


def string2bin(s):
# prend une chaine de caracteres en entree, renvoie une CdC de la forme '100110110'
	resultat = ''
	for x in s : 
		l = bin(ord(x))	
		l = l[2:]  # on enleve le '0b'
		while len(l) < 7 :   # on ajoute des zeros au besoin 
			l = '0' + l
		resultat = resultat + l
	return resultat

def bin2string(b):
#idem qu'avant, mais l'inverse
	res = ''
	n = len(b)/7  #nb de caracteres
	for i in range(n) :
		char_bin = '0b' + b[7*i:7*(i+1)]
		char = chr(eval(char_bin))
		res = res+char
	return res

#Verif : bin2string(string2bin('1sdald4xc65tyonvs'))





#---------------Operations de hashage-----------------------


def xor(a,b) : 
# Realise le OU exclusif de deux binaires a et b, element par element
# on suppose que length(a)==length(b)
	if len(a) == 1 : 
		if a == '0' : 
			return b
		elif b == '1' :   #a = b = 1
			return '0' 
		else :	return '1'
	else :
		res = ''
		for i in range(len(a)) : 
			res = res + xor(a[i],b[i])
		return res		


#Verif : table de verite : xor('1100','1010')


L1 = [14, 11, 36, 21, 10, 2, 42, 32, 1, 53, 22, 26, 18, 46, 59, 63, 4, 51, 19, 52, 0, 34, 12, 17, 45, 54, 57, 47, 38, 13, 58, 31, 61, 25, 7, 6, 40, 62, 49, 39, 23, 43, 20, 5, 27, 60, 50, 55, 29, 35, 44, 15, 9, 33, 16, 30, 56, 41, 3, 28, 24, 48, 8, 37]


L2 = [52, 22, 38, 15, 28, 29, 56, 23, 60, 18, 41, 45, 59, 0, 8, 50, 35, 57, 6, 5, 44, 62, 2, 7, 4, 13, 16, 43, 39, 40, 11, 20, 46, 42, 21, 49, 47, 61, 25, 12, 34, 24, 26, 58, 53, 1, 27, 9, 3, 10, 54, 17, 36, 14, 37, 63, 32, 31, 55, 48, 33, 30, 19, 51]


L3 = [22, 54, 61, 42, 38, 0, 5, 63, 2, 24, 39, 15, 52, 20, 16, 50, 31, 1, 28, 11, 32, 8, 59, 55, 18, 62, 25, 27, 12, 51, 48, 21, 56, 47, 3, 35, 45, 43, 9, 37, 34, 26, 30, 14, 44, 60, 33, 6, 23, 41, 40, 10, 13, 36, 57, 19, 7, 58, 17, 49, 4, 29, 53, 46]


#Tables de permutations obtenues aleatoirement grace au script suivant : 


def table() : 
# renvoie une table qui contient une et une seule fois les entiers de 0 a 63 (inclus)
	t = []
	L = range(64) # liste des entiers a ajouter (se vide progressivement)
	for i in range(64) : 
		ind = random.randint(0,63-i)
		t.append(L[ind])
		L = L[:ind] + L[ind+1:]
	return t

# Verif : t = table()
#    l = [t.count(i) for i in range(64)]                  l = [1,1,1,...,1]



def permutation(b,i,direct = True):
# b est un binaire entre 0 et 127
	if i==0 :
		table_de_permutation = L1
	elif i==1 :
		table_de_permutation = L2
	else :   #i==2
		table_de_permutation = L3
	if direct :          # sens direct : x-ieme element
		x = eval('0b' + b) 
		l =  bin(table_de_permutation[x])		
	else : 			# sens indurect : element i tq x est le i-ieme element
		x = eval('0b' + b) 
		l =  bin(table_de_permutation.index(x))
	l = l[2:]
	while len(l) < 6:   # on n'oublie pas les zeros
		l =  '0' + l
	return l


# Verif : permutation(permutation('1010101',2),2,False)
# OU      permutation(permutation('1101100',2,False),2)





def hachage_12o(x) : 
#prend en entree un binaire x de taille 12 et renvoie son hache.
	cle1 = '011010100110'   # choisies aleatoirement
	cle2 = '000111110010'
	for i in range(30) :
		a = x[:6]
		b = x[6:12]
		b = xor(a,b)
		x = b+a
		
		a = x[:6]
		b = x[6:12]
		a = permutation(a,i%3,i%2)
		b = permutation(a,(2*i)%3,i%2)
		x = a+b

		x = xor(x,cle1)

		cle2 = xor(x,cle2)

		a = x[0::2]
		b = x[1::2]		
		x = xor(b+a,xor(cle1,cle2))
	
		cle1 = xor(b+a,cle1) 
	return x




		 

def hachage(s):
#prend une CdC s de longueur quelconque et renvoie son hache
	l = separation(s)
	resultat = '000000000000'
	for x in l : 
		a = hachage_12o(x)
		resultat = xor(resultat,a)
	return resultat	



#Verif : repartition 
# on veut s'assurer que la proba d'avoir un '1' vaut 0.5
# Pour cela, on hache des chaines de caractere aleatoires, et on mesure la frequence de '1' 


def verif_repartition(I = 100,taille=36) :
	hist = [0 for i in range(12)] # histogramme des probas d'apparition de '1'
	for i in range(I) : 
		# construction d'une string : 
		s = ''
		for j in range(taille) : 
			a = random.randint(0,127)
			s = s+chr(a)
		hache = hachage(s)
		for i in range(12) : 
			hist[i] = hist[i] + eval(hache[i])
	return [x*100./I for x in hist]
	

# Pour vérifier que le hash est suffisamment éloigné, on prend 10 chaines se caractere
# qui different d'au moins 1 caractere, et on regarde leur hache

def verif_complexite(taille = 36):
	s = ''
	for j in range(taille) : 
		a = random.randint(0,127)
		s = s+chr(a)
	tab = [s]
	for j in range(taille) :
		a = random.randint(0,127)
		s2 = s[:j] + chr(a) + s[j+1:]
		tab = tab + [s2]
	for s in tab : 
		print hachage(s)
	
	











