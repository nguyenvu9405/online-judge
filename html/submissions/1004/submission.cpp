#include<cstdio>

long long s=0, t=0, pre_t=0, u=1e12;
long a[33], v=0, v2=0;;
int n, cnt=0;

long long abs(long long n)
{
    if (n>=0) return n; return -n;
}

void update(long long p)
{
    if (abs(2*p-s)==u&&2*cnt<n) ++v;
    if (abs(2*p-s)==u&&2*cnt==n) ++v2;
    if (abs(2*p-s)<u)
    {
        u=abs(2*p-s);
        v=v2=0;
        if (2*cnt-n) ++v; else ++v2;
    }
}

void divide(int j, int p)
{
    if (2*t>=s)
    {
        update(t);
        --cnt;
        update(pre_t);
        ++cnt;
    }
    else
    for (int i=p; i<=n; ++i)
    {
        pre_t=t;
        t+=a[i];
        ++cnt;
        if (j<n/2) divide(j+1, i+1);
        else update(t);
        --cnt;
        t-=a[i];
    }
}

int main()
{
    scanf("%d", &n);
    for (int i=1; i<=n; ++i) scanf("%ld", a+i);
    for (int i=1; i<=n; ++i) s+=a[i];
    divide(1, 1);
    printf("%lld %ld", u, v+v2/2);
    return 0;
}
