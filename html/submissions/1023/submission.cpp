#include<bits/stdc++.h>
long long o=1,n,res=0,x[40],a[100000],d=0;
bool b[40],c[40];
void hv(long long i)
{
    for (int j=2;j<=n;j++)
    {
        if (b[j]&&c[x[i-1]+j]==true)
        {
            x[i]=j;
            b[j]=false;
            if (i==n)
            {
                if (c[1+x[n]]==true) res++;
            }
            else hv(i+1);
            b[j]=true;
        }
    }
}
int main()
{
    scanf("%lld",&n);
    n=n*2;
    memset(b,true,sizeof(b));
    memset(c,false,sizeof(c));
    x[1]=1;
    c[2]=true;c[3]=true;c[5]=true;c[7]=true;c[11]=true;c[13]=true;c[17]=true;c[19]=true;c[23]=true;c[29]=true;c[31]=true;c[37]=true;
    hv(2);
    printf("%lld",res);
}
