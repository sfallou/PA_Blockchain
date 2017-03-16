import random
import math
import time

N = 3

# Pour le test de primalite, on construit un tableau regroupant les entiers premiers de 1 a 100
# On peut se le permettre DANS NOTRE CAS

# on utilise une fonction recursive : 
# gene_tab renvoie tous les entiers premiers entre x et racine(10^4)

def gene_tab(x,tab) : 
	if x == int(10**(N-1))+1 : 
		return tab
	b = x+1
	for i in tab : 
		if x%i == 0 :    # si x est divisible par un premier
			return gene_tab(b,tab)
	tab = tab+[x]
	return gene_tab(b,tab)


tab_prem = gene_tab(2 , [])


def isprime(p) :	
	for i in tab_prem : 
		if p%i == 0 and p != i :    # si x est divisible par un premier
			return False
	return True


def generation_premier(n=N) : 
	# renvoie un entier premier aleatoire, de n chiffres
	# Pour aller 2 fois plus vite, on utilise des entiers impairs
	p = 2 * random.randint(5 *10**(n-1) +2, 5 *10**n) +1
	while not isprime(p) :
		p = p+2
		if p >= 10**(n+1) : 
			p = 10**n +1
 	return p





def premier_avec(a) :
# renvoie un entier premier avec a et inferieur a a 
# pour cela, on multiplie des entiers premiers qui ne sont pas diviseurs de a
# jusqu'a ce qu'on atteigne a 
	t = tab_prem
	b = 1
	for i in tab_prem : 
		if a%i != 0  : 
			b = b*i
		if b >= a :           # c'est trop tard :
			return (b/i)  # on revient une etape en arriere
	print(a,tab_prem)
	

# Pour inverser modulo m, on utilise Euclide
# a*p + b*q = 1
# a = x
# b = m
# ou vice-versa

def Euclide_rec(a,p1,p2,b,q1,q2) : 
#a*(p1-p2) + b*(q1-q2) > 0
	if a*p2 + b*q2 == 1 :
		return (p2,q2)
	else : 
		i = 0
		while a*(p1-i*p2) + b*(q1-i*q2) > 0 :
			i = i+1
		i = i-1
		return Euclide_rec(a,p2,p1-i*p2,b,q2,q1-i*q2) 



def inv(x,m) : 
	if x > m : 
		(p,q) = Euclide_rec(x,1,0,m,0,1)
		return p
	else : 
		(p,q) = Euclide_rec(m,1,0,x,0,1)
		return q

def verif_euclid(n = 100) :
	for i in range(n) :
		q = random.randint(5,10**N)
		e = premier_avec(q)
		d = inv(e,q)%q
		print((d*e)%q)  



def Generation_cles()  :
# On veut deux entiers p et q, premiers, de 4 chiffres (les temps de calcul ne sont plus negligeables au-dela)
	p,q = 0,0
	while p==q  :	# on ne veut pas que q = p, et pq assez grand
		p = generation_premier()
		q = generation_premier()
		n = p*q 
	e = premier_avec((p-1)*(q-1))%((p-1)*(q-1)) #tq e soit premier avec (p-1)(q-1) inferieur a (p-1)(q-1)
	d = inv(e,(p-1)*(q-1))%((p-1)*(q-1))         # tq e.d = 1 [mod (p-1)(q-1) ]
	return (d,(n,e))
	# (cle privee, cle publique)
	

(clepriv_ex,clepub_ex) = (53510245,(77633657, 37182145))



def puiss(a,b,n = 1) : 
	if b == 0 :
		return 1
	elif b == 1 :
		return a
	elif b%2 == 0 :
		return (puiss(a,b//2,n)**2)%n
	else :
		return a*(puiss(a,b//2,n)**2)%n
	

# Decryptage(Cryptage(1234567))
# 


def Cryptage(M,clepub) :
	(n,e) = clepub
	C = (puiss(M,e,n) )%n
	return C



def num2string(n) :
	res = '' 
	while not n==0 : 
		r = n%36
		n = (n-r)//36
		if r < 10 :
			res = str(r) + res
		else : 
			res =  chr(r - 10 + ord('a')) + res
	return res 
	
# int(  num2string(12345)  ,36)
# num2string( int("abcdefgh",36))
	


def verif_num2str(n = 10000) :
	s = 0
	for i in range(n) : 
		x = random.randint(1,10000000000)
		x2 = int(  num2string(x)  ,36)
		if x == x2 : 
			s = s+1
	return s





def Decryptage(C,clepriv ,clepub) :
	(n,e) = clepub
	d = clepriv
	M =  puiss(C,d,n)%n
	return M


def verif_cryptage() : 
	(clepriv,clepub) = Generation_cles()
	(n,e) = clepub
	d = clepriv
	M = random.randint(10000,1000000)
	print("d = "+str(d))
	print("n = "+str(n))
	print("e = "+str(e))
	print("M = "+str(M))
	C = (puiss(M,e,n) )%n
	M =  puiss(C,d,n)%n
	print("M = "+str(M))
	print("C = "+str(C))
	print('')
	print('')
	print('')
	print('')




def Visualisation(att = True,gene = True) : 
	print('')
	print('')
	print('')
	print('')
	print("                               Alice                                                      Bob   ")
	print("Generation des cles :      ") 
	if att :
		time.sleep(1)
	if gene :                   
		(clepriv,clepub) = Generation_cles()
	else : 
		(clepriv,clepub) = (clepriv_ex,clepub_ex)
	print("                      " + str(clepriv) +',' + str(clepub))
	if att :
		time.sleep(1)
	print("Envoi des clefs :")
	if att :
		time.sleep(1)
	print("                      " + str(clepriv) +',' + str(clepub)+'       ------(n,e)------>       '+str(clepub))
	if att :
		time.sleep(1)
	print("Cryptage :")
	if att :
		time.sleep(1)
	M = "hello"
	print("                                                                                             M")
	print("                                                                                           "+str(M))
	print("                                                                                          "+str(int(M,36)))
	print('')
	C = Cryptage(int(M,36),clepub)
	print("                                                                                             C")
	print("                                                                                           "+str(C))
	if att :
		time.sleep(1)
	print("Envoi du message : ")
	if att :
		time.sleep(1)
	print("                                "+str(C)+"                   <--------------                 "+str(C))
	print("                                  C"  ) 
	print("                                " +str(C))
	if att :
		time.sleep(1)
	print("Decryptage : ")
	if att : time.sleep(1)
	print("                                  M"  )
	print("                                " +num2string(Decryptage(C,clepriv,clepub)))
	print("                               "+ str(Decryptage(C,clepriv,clepub)))	
	print('')
	print('')
	print('')
	print('')











