#include<iostream>
#include<cstring>
#include<stdio.h>
#include<math.h>
using namespace std;
bool ok=true;
long long a[30],b[10],n,d0=0,d1=0,k,d=0,t;
long long Ngto(long long t)
{
    long long i;
    for(i=2;i<=trunc(sqrt(t));i++)
        if (t%i==0) return 1;
    return 0;
}
void output()
{
    for(int i=1;i<=n;i++)
        cout << a[i] << " ";
    cout << endl;
}
long long tim (long long i)
{
    long long k=0,s,o=1;
    for(long long j=2;j<=n;j++)
    {
        a[1]=1;
        b[1]=1;
        if ((b[j]==0)&&(Ngto(a[i-1]+j)==0))
        {
            a[i]=j;
            b[j]=1;
            if((Ngto(a[1]+a[n])==0)&&(i==n))
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
    for (int i=1; i<=n; i++)
        b[i]=0;
    printf("%lld",tim(2));
    return 0;
}
