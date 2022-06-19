import math
def fib(Number):  
  i = 0
  First_Value = 0
  Second_Value = 1
  sum=1
  while(i < Number):
    if(i <= 1):
                Next = i
    else:
                Next = First_Value + Second_Value
                First_Value = Second_Value
                Second_Value = Next
                sum=sum+Next
    i = i + 1
  print(sum) 
fib(5)
###########################################################################


def binomialCoefficients():
    x = int(input("Enter a value for x: "))
    y = int(input("Enter a value for y: "))

    if y == 1 or y == x:
        print(1)

    if y > x:
        print(0)        
    else:
        a = math.factorial(x)
        b = math.factorial(y)
        div = a // (b*(x-y))
        print(div)  
print('binomial Coefficients:')
binomialCoefficients()

##########################################################################

from collections import defaultdict

class Graph:
 
    def __init__(self, vertices):
        self.V = vertices
    def printSolution(self, reach):
        print ("Following matrix transitive closure of the given graph ")    
        for i in range(self.V):
            for j in range(self.V):
                if (i == j):
                  print ("%7d\t" % (1)),
                else:
                  print ("%7d\t" %(reach[i][j])),
            print ("")
    def transitiveClosure(self,graph):
 
        reach =[i[:] for i in graph]

        for k in range(self.V):

            for i in range(self.V):

                for j in range(self.V):

                    reach[i][j] = reach[i][j] or (reach[i][k] and reach[k][j])
 
        self.printSolution(reach)
         
g= Graph(4)
 
graph = [[1, 1, 0, 1],
         [0, 1, 1, 0],
         [0, 0, 1, 1],
         [0, 0, 0, 1]]
 
g.transitiveClosure(graph)

################################################################################
print('Floyd’s algorithm ')
nV = 4

INF = 999

def floyd_warshall(G):
    distance = list(map(lambda i: list(map(lambda j: j, i)), G))

    for k in range(nV):
        for i in range(nV):
            for j in range(nV):
                distance[i][j] = min(distance[i][j], distance[i][k] + distance[k][j])
    print_solution(distance)

def print_solution(distance):
    for i in range(nV):
        for j in range(nV):
            if(distance[i][j] == INF):
                print("INF", end=" ")
            else:
                print(distance[i][j], end="  ")
        print(" ")


G = [[0, 3, INF, 5],
         [2, 0, INF, 4],
         [INF, 1, 0, INF],
         [INF, INF, 2, 0]]
floyd_warshall(G)

###########################################################################
def knapSack(W, wt, val, n):
   K = [[0 for x in range(W + 1)] for x in range(n + 1)]
   for i in range(n + 1):
      for w in range(W + 1):
         if i == 0 or w == 0:
            K[i][w] = 0
         elif wt[i-1] <= w:
            K[i][w] = max(val[i-1] + K[i-1][w-wt[i-1]], K[i-1][w])
         else:
            K[i][w] = K[i-1][w]
   return K[n][W]
print('knap Sack')
val = [50,100,150,200]
wt = [8,16,32,40]
W = 64
n = len(val)
print(knapSack(W, wt, val, n))

############################################################################
