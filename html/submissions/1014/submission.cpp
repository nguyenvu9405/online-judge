#include<bits/stdc++.h>
using namespace std;
int d0=0,s=0,d1=0,res=0,a[100],b[100],n,k,l,x,i=0,u,t1=0,n2;
long DN(long u)
{
    x=0;
    for(l=1;l<=u/2;l++)
    if(u%l==0) {x++;if(x>1)return(0);}
    return(1);
}
/*ng check()
{
    t1=0;a[1]=1;
    a[n+1]=a[1];
    for(int t=1;t<=n;t++)
    {
       // printf("%d ",a[t]);
        //a[n+1]=a[1];
        u=a[t]+a[t+1];
        if(DN(u)==1)t1++;
    }
    //printf("\n");
    if(t1==n)
        return(1); else return(0);
}*/
void init ()
{
    cin >> n;
    n=n*2;
}
void tim (int i)
{
    for(int j=2;j<=n;j++)
        {a[1]=1;
        if ((b[j]==true)&&(DN(a[i-1]+j)==1))
        {
        a[i]=j;
        b[j]=false;
        if(i<n) tim(i+1);
        else if ( DN(a[1]+a[i])==1) res++;
        //else tim(i+1);
        b[j]=true;
        }}
}
int main()
{
    init();
    for(k=1;k<=n;k++)
        b[k]=true;
     tim(2);
     printf("%d",res);
    return 0;
}

