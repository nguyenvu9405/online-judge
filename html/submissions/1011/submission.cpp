#include<iostream>
#include<cstring>
#include<stdio.h>
using namespace std;
long long a[30],b[10],n,d0=0,d1=0,k,d=0;
long long dem()
{
    long long d0=0,d1=0;
    for(long long i=0;i<n;i++)
       {
           if (a[i]==0) d0++;
           else d1++;
           if (d0<d1) return 0   ;
       }

    if ((d0>=d1)&&(d0<=n/2))
        return 1;
    else return 0;

}
void output()
{
    for(int i=0;i<n;i++)
        cout << a[i];
    cout << endl;
}
long long tim (long long i)
{
    long long k;
    for(long long j=0;j<=1;j++)
    {
        a[i]=j;
        if ((i==n-1))
          {
              d=d+dem();

          }
        else
            tim(i+1);
    }
}
int main()
{
    scanf("%lld",&n);
    tim(0);
    printf("%lld",d);
    return 0;
}

