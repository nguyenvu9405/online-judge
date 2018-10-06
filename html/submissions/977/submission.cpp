#include<bits/stdc++.h>
long long o=1,n,res=0,x[22],a[100000],d=0;
bool b[22];
bool check(long long x)
{
    for (long long i=2;i<=trunc(sqrt(x));i++) if (x%i==0) return(false);
    return(true);
}
bool output()
{
    if (check(x[1]+x[n])==true) return(true);
    else return(false);
}
void hv(long long i)
{
    for (int j=1;j<=n;j++)
    {
        if (b[j]==true&&check(x[i-1]+j)==true)
        {
            x[i]=j;
            b[j]=false;
            if (i==n)
            {
                if(output()==true) res++;
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
    x[1]=1;
    b[1]=false;
    hv(2);
    printf("%lld",res);
}

