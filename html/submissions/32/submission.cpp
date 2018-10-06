#include<bits/stdc++.h>
long long x[31],a[3],n,res=0;
void hv(long long i)
{
    for (long long j=0;j<=1;j++)
    {
        a[j]++;
        if (a[0]>=a[1]&&a[0]<=n/2)
        {
            x[i]=j;
            if (i==n) res++;
            else hv(i+1);
            a[j]--;
        }
        else a[j]--;
    }
}
int main()
{
    scanf("%lld",&n);
    hv(1);
    printf("%lld",res);
}
