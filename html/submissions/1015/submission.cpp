#include<bits/stdc++.h>
using namespace std;
int d0=0,s=0,d1=0,a[100],b[10],n,k,l,x[100],i=0;
long check()
{
    d0=0;d1=0;
    for(int t=1;t<=n;t++)
    {
        if(a[t]==0)d0++;
        else d1++;
        if(d0<d1&&d0<=n/2||d0>n/2)return 0;
    }
    if(d0==d1) return(1);else return(0);
}
void init ()
{
    cin >> n;
}
void tim (int i)
{
    for (int j=0;j<=1;j++)
    {
        a[i]=j;
        if(i==n)
        s=s+check();
        else tim(i+1);
    }
}
int main()
{
    init();
     tim(1);
     printf("%d",s);
    return 0;
}

