#include<bits/stdc++.h>
long long n,res=0,x[40],a[12],d=0;
bool b[40];
output()
{
    for (int i=1;i<n;i++)
    {
        for (int j=1;j<i;j++)
        for (int l=i+1;l<=n;l++)
        if (x[i]*2==x[j]+x[l]) return(false);
    }
    return(true);
}
void hv(long long i)
{
    for (long j=1;j<=n;j++)
    {
        if (b[j])
        {
            x[i]=a[j];
            b[j]=false;
            if (i==n)
            {
                if (output()==true) res++;
            }
            else hv(i+1);
            b[j]=true;
        }

    }
}
int main()
{
    scanf("%lld",&n);
    for (int i=1;i<=n;i++) scanf("%lld",&a[i]);
    memset(b,true,sizeof(b));
    hv(1);
    printf("%lld",res);
}
