#include<iostream>
#include<cstring>
#include<stdio.h>
#include<math.h>
using namespace std;
bool ok=true;
long long a[30000],b[10000],n,d0=0,d1=0,k,d=0,t,c[100000];
long long tim (long long i)
{
    long long k=0,s,o=1;
    for(long long j=2;j<=n;j++)
    {
        a[1]=1;
        if ((b[j]==0)&&(c[a[i-1]+j]==true))
        {
            a[i]=j;
            b[j]=1;
            if((c[a[1]+a[n]]==true)&&(i==n))
            {
                d++;
            }
            else tim(i+1);
            b[j]=0;
        }
    }
    return d;
}
int main()
{
    scanf("%lld",&n);
    n=n*2;
    a[n+1]=a[1];
    for (int i=1;i<=n;i++)
        b[i]=0;
    c[3]=true;c[2]=true;c[5]=true;c[7]=true;c[11]=true;c[13]=true;c[17]=true;c[19]=true;c[23]=true;c[29]=true;c[31]=true;c[37]=true;c[41]=true;
    printf("%lld",tim(2));
    return 0;
}
