#include<bits/stdc++.h>
using namespace std;
int d0=0,s=0,d1=0,res=0,a[100],b[100],n,k,l,x,i=0,u,t1=0,n2;
bool snt[100];
long DN(long u)
{
    x=0;
    for(l=2;l<=sqrt(u);l++)
    if(u%l==0) return(0);
    return(1);
}
void init ()
{
    cin >> n;
    n=n*2;
}
void tim (int i)
{
    for(int j=2;j<=n;j++)
        {a[1]=1;
        if ((b[j]==true)&&(snt[a[i-1]+j]==true))
        {
        a[i]=j;
        b[j]=false;
        if (i<n) tim(i+1);
        else if (snt[1+a[i]]==true) res++;
        //else tim(i+1);
        b[j]=true;
        }}
}
int main()
{
    init();
    for(k=1;k<=n;k++)
        b[k]=true;
    for (int i=1; i<=40; i++)
        if (DN(i))  snt[i]=true;
    else snt[i]=false;
     tim(2);
     printf("%d",res);
    return 0;
}
