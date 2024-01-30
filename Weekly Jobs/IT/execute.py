import time
# time.sleep(10)
# print('Condition True')
import sys
i=0
while i<100:
    i = i + 1
    f = open('Nrefile1.txt','a')
    f.writelines(sys.argv[1:])
    print(sys.argv[1:])
    f.writelines(str(i))
    f.close()
    time.sleep(10)


